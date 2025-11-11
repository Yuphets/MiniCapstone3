<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityMaster extends Model
{
    use HasFactory;

    protected $table = 'activities_master';

    protected $fillable = [
        'name',
        'activity_type',
        'calories_per_min',
        'default_duration_min',
        'description'
    ];

    protected $casts = [
        'calories_per_min' => 'decimal:3',
        'default_duration_min' => 'integer'
    ];

    public function workoutLogs()
    {
        return $this->hasMany(WorkoutLog::class);
    }
}
