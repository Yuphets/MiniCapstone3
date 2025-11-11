<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'full_name',
        'dob',
        'gender',
        'height_cm',
        'weight_kg',
        'goal_text',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'dob' => 'date',
        'height_cm' => 'decimal:2',
        'weight_kg' => 'decimal:2',
    ];

    // Relationships
    public function workoutLogs()
    {
        return $this->hasMany(WorkoutLog::class);
    }

    public function mealLogs()
    {
        return $this->hasMany(MealLog::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function bodyMetrics()
    {
        return $this->hasMany(BodyMetric::class);
    }

    public function dailySummaries()
    {
        return $this->hasMany(DailySummary::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    // Helper methods
    public function getCurrentWeightAttribute()
    {
        return $this->bodyMetrics()->latest()->first()?->weight_kg;
    }

    public function getCurrentBmiAttribute()
    {
        return $this->bodyMetrics()->latest()->first()?->bmi;
    }

    public function getActiveGoalsAttribute()
    {
        return $this->goals()->where('status', 'active')->get();
    }
}
