<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailySummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'summary_date',
        'calories_in',
        'calories_out',
        'steps'
    ];

    protected $casts = [
        'summary_date' => 'date',
        'calories_in' => 'decimal:2',
        'calories_out' => 'decimal:2',
        'steps' => 'integer',
        'net_calories' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Update summary when related data changes
    public function updateSummary()
    {
        $caloriesIn = MealLog::where('user_id', $this->user_id)
            ->where('meal_date', $this->summary_date)
            ->sum('total_calories');

        $caloriesOut = WorkoutLog::where('user_id', $this->user_id)
            ->where('activity_date', $this->summary_date)
            ->sum('calories_burned');

        $this->update([
            'calories_in' => $caloriesIn,
            'calories_out' => $caloriesOut
        ]);
    }
}
