<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\MealLog;
use App\Models\WorkoutLog;
use App\Models\BodyMetric;
use App\Models\ActivityMaster;
use App\Models\FoodItem;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Helper method to check admin access
    private function checkAdmin()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login to access this page.');
        }

        if (!Auth::user()->is_admin) {
            return redirect('/dashboard')->with('error', 'Unauthorized access. Admin privileges required.');
        }
    }

    public function dashboard()
    {
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }

        $totalUsers = User::count();
        $totalAdmins = User::where('is_admin', true)->count();
        $mealsToday = MealLog::whereDate('meal_date', today())->count();
        $workoutsToday = WorkoutLog::whereDate('activity_date', today())->count();
        $totalActivities = ActivityMaster::count();
        $totalFoodItems = FoodItem::count();

        // Recent users (last 7 days)
        $recentUsers = User::where('created_at', '>=', now()->subDays(7))->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'mealsToday',
            'workoutsToday',
            'totalActivities',
            'totalFoodItems',
            'recentUsers'
        ));
    }

    public function users()
    {
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }

        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function activityLogs()
    {
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }

        $mealLogs = MealLog::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'meal_page');

        $workoutLogs = WorkoutLog::with(['user', 'activity'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'workout_page');

        return view('admin.activity-logs', compact('mealLogs', 'workoutLogs'));
    }

    public function exerciseData()
    {
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }

        $activities = ActivityMaster::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.exercise-data', compact('activities'));
    }

    public function nutritionData()
    {
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }

        $foodItems = FoodItem::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.nutrition-data', compact('foodItems'));
    }

   public function generateReports()
{
    $adminCheck = $this->checkAdmin();
    if ($adminCheck) {
        return $adminCheck;
    }

    // User growth report (last 30 days)
    $userGrowth = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

    // Activity statistics - Using manual count to be safe
    $activities = ActivityMaster::all();
    $activityStats = $activities->map(function($activity) {
        $workoutCount = WorkoutLog::where('activity_id', $activity->id)->count();
        $activity->workout_logs_count = $workoutCount;
        return $activity;
    })->sortByDesc('workout_logs_count');

    // Nutrition statistics
    $popularFoods = FoodItem::withCount('mealItems')
        ->orderBy('meal_items_count', 'desc')
        ->take(10)
        ->get();

    return view('admin.reports', compact('userGrowth', 'activityStats', 'popularFoods'));
}

    public function manageUser(Request $request, $id)
    {
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }

        $user = User::findOrFail($id);

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'is_admin' => 'boolean',
            ]);

            $user->update($validated);
            return redirect()->route('admin.users')->with('success', 'User updated successfully!');
        }

        return view('admin.manage-user', compact('user'));
    }

    public function deleteUser($id)
    {
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }

        $user = User::findOrFail($id);

        // Prevent admin from deleting themselves
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }

    public function createActivity(Request $request)
    {
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'activity_type' => 'required|string|max:255',
                'calories_per_min' => 'required|numeric|min:0',
                'default_duration_min' => 'required|integer|min:1',
                'description' => 'nullable|string',
            ]);

            ActivityMaster::create($validated);
            return redirect()->route('admin.exercise-data')->with('success', 'Activity created successfully!');
        }

        return view('admin.create-activity');
    }

    public function createFoodItem(Request $request)
    {
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'brand' => 'nullable|string|max:255',
                'category' => 'nullable|string|max:255',
                'serving_qty' => 'required|numeric|min:0',
                'serving_unit' => 'required|string|max:50',
                'calories' => 'required|numeric|min:0',
                'protein_g' => 'required|numeric|min:0',
                'carbs_g' => 'required|numeric|min:0',
                'fats_g' => 'required|numeric|min:0',
                'notes' => 'nullable|string',
            ]);

            FoodItem::create($validated);
            return redirect()->route('admin.nutrition-data')->with('success', 'Food item created successfully!');
        }

        return view('admin.create-food-item');
    }

    public function deleteActivity($id)
    {
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }

        $activity = ActivityMaster::findOrFail($id);
        $activity->delete();

        return redirect()->route('admin.exercise-data')->with('success', 'Activity deleted successfully!');
    }

    public function deleteFoodItem($id)
    {
        $adminCheck = $this->checkAdmin();
        if ($adminCheck) {
            return $adminCheck;
        }

        $foodItem = FoodItem::findOrFail($id);
        $foodItem->delete();

        return redirect()->route('admin.nutrition-data')->with('success', 'Food item deleted successfully!');
    }
}
