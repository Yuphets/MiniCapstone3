<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\WorkoutLog;
use App\Models\ActivityMaster;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WorkoutTracker extends Component
{
    protected $layout = 'layouts.app';

    public $workouts = [];
    public $activities;
    public $showForm = false;
    public $editingId = null;
    public $form = [
        'activity_id' => '',
        'activity_date' => '',
        'start_time' => '',
        'duration_min' => 30,
        'notes' => ''
    ];

    protected $rules = [
        'form.activity_id' => 'required|exists:activities_master,id',
        'form.activity_date' => 'required|date',
        'form.duration_min' => 'required|integer|min:1',
        'form.start_time' => 'nullable',
        'form.notes' => 'nullable|string|max:500'
    ];

    public function mount(): void
    {
        $this->activities = ActivityMaster::all();
        $this->form['activity_date'] = today()->format('Y-m-d');
        $this->form['start_time'] = now()->format('H:i');
        $this->loadWorkouts();
    }

    public function loadWorkouts(): void
    {
        $userId = Auth::id();
        if (!$userId) {
            return;
        }

        $this->workouts = WorkoutLog::with('activity')
            ->where('user_id', $userId)
            ->where('activity_date', $this->form['activity_date'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function startWorkout(): void
    {
        $this->showForm = true;
        $this->editingId = null;
        $this->resetForm();
    }

    public function saveWorkout(): void
    {
        $this->validate();
        $activity = ActivityMaster::find($this->form['activity_id']);

        if ($activity) {
            $caloriesBurned = $activity->calories_per_min * $this->form['duration_min'];

            $workoutData = [
                'user_id' => Auth::id(),
                'activity_id' => $this->form['activity_id'],
                'activity_date' => $this->form['activity_date'],
                'start_time' => $this->form['start_time'],
                'duration_min' => $this->form['duration_min'],
                'calories_burned' => $caloriesBurned,
                'notes' => $this->form['notes']
            ];

            if ($this->editingId) {
                WorkoutLog::find($this->editingId)?->update($workoutData);
                session()->flash('message', 'Workout updated successfully!');
            } else {
                WorkoutLog::create($workoutData);
                session()->flash('message', 'Workout logged successfully!');
            }

            $this->cancelEdit();
            $this->loadWorkouts();
        }
    }

    /**
     * Edit an existing workout
     *
     * @param int $id
     * @return void
     */
    public function editWorkout(int $id): void
    {
        $workout = WorkoutLog::find($id);
        if ($workout) {
            $this->form = [
                'activity_id' => $workout->activity_id,
                'activity_date' => $workout->activity_date->format('Y-m-d'),
                'start_time' => $workout->start_time,
                'duration_min' => $workout->duration_min,
                'notes' => $workout->notes
            ];
            $this->editingId = $id;
            $this->showForm = true;
        }
    }

    /**
     * Delete a workout
     *
     * @param int $id
     * @return void
     */
    public function deleteWorkout(int $id): void
    {
        $workout = WorkoutLog::find($id);
        if ($workout) {
            $workout->delete();
            $this->loadWorkouts();
            session()->flash('message', 'Workout deleted successfully!');
        }
    }

    public function cancelEdit(): void
    {
        $this->showForm = false;
        $this->editingId = null;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->form = [
            'activity_id' => '',
            'activity_date' => today()->format('Y-m-d'),
            'start_time' => now()->format('H:i'),
            'duration_min' => 30,
            'notes' => ''
        ];
    }

    public function updatedFormActivityDate(): void
    {
        $this->loadWorkouts();
    }

    /**
     * Render the component view
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('livewire.workout-tracker');
    }
}
