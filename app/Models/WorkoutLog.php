<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity_id',
        'activity_date',
        'start_time',
        'duration_min',
        'calories_burned',
        'notes'
    ];

    protected $casts = [
        'activity_date' => 'date',
        'calories_burned' => 'decimal:2',
        'duration_min' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity()
    {
        return $this->belongsTo(ActivityMaster::class, 'activity_id');
    }
}
