<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\BodyMetric;
use App\Models\Goal;
use App\Models\Achievement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProgressTracker extends Component
{
    // Use the layout property instead of method
    protected $layout = 'layouts.app';

    public $weight;
    public $bodyFat;
    public $waist;
    public $goals = [];
    public $achievements = [];
    public $weightHistory = [];
    public $selectedPeriod = '30'; // days
    public $goalForm = [
        'goal_type' => 'weight_loss',
        'target_value' => '',
        'unit' => 'kg',
        'start_date' => '',
        'end_date' => ''
    ];

    protected $rules = [
        'weight' => 'required|numeric|min:20|max:300',
        'bodyFat' => 'nullable|numeric|min:0|max:100',
        'waist' => 'nullable|numeric|min:20|max:200',
    ];

    public function mount(): void
    {
        $this->goalForm['start_date'] = today()->format('Y-m-d');
        $this->goalForm['end_date'] = today()->addMonth()->format('Y-m-d');
        $this->loadProgressData();
    }

    public function loadProgressData(): void
    {
        $userId = Auth::id();
        if (!$userId) {
            return;
        }

        // Load latest body metrics
        $latestMetric = BodyMetric::where('user_id', $userId)
            ->latest('measured_at')
            ->first();

        if ($latestMetric) {
            $this->weight = $latestMetric->weight_kg;
            $this->bodyFat = $latestMetric->body_fat_pct;
            $this->waist = $latestMetric->waist_cm;
        }

        // Load goals
        $this->goals = Goal::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Load achievements
        $this->achievements = Achievement::where('user_id', $userId)
            ->with('goal')
            ->orderBy('achieved_at', 'desc')
            ->get();

        // Load weight history
        $this->loadWeightHistory();
    }

    public function loadWeightHistory(): void
    {
        $userId = Auth::id();
        if (!$userId) {
            return;
        }

        $this->weightHistory = BodyMetric::where('user_id', $userId)
            ->where('measured_at', '>=', now()->subDays($this->selectedPeriod))
            ->orderBy('measured_at')
            ->get(['measured_at', 'weight_kg', 'bmi']);
    }

    public function saveBodyMetric(): void
    {
        $this->validate();

        $user = Auth::user();
        if (!$user) {
            return;
        }

        $height = $user->height_cm ?? 170; // Default height if not set

        // Calculate BMI
        $heightInMeters = $height / 100;
        $bmi = $this->weight / ($heightInMeters * $heightInMeters);

        BodyMetric::create([
            'user_id' => Auth::id(),
            'measured_at' => today(),
            'weight_kg' => $this->weight,
            'body_fat_pct' => $this->bodyFat,
            'waist_cm' => $this->waist,
            'bmi' => round($bmi, 2)
        ]);

        // Update user's current weight
        $user->update(['weight_kg' => $this->weight]);

        $this->loadProgressData();
        session()->flash('message', 'Body metrics updated successfully!');
    }

    /**
     * Render the component view
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('livewire.progress-tracker');
    }
}
