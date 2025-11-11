<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'goal_type',
        'target_value',
        'unit',
        'start_date',
        'end_date',
        'status',
        'achieved_at'
    ];

    protected $casts = [
        'target_value' => 'decimal:3',
        'start_date' => 'date',
        'end_date' => 'date',
        'achieved_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    // Check if goal is completed
    public function getIsCompletedAttribute()
    {
        return $this->status === 'completed';
    }

    // Calculate progress percentage
    public function getProgressPercentageAttribute()
    {
        // This would be implemented based on the goal type
        // For example, for weight loss goals:
        if ($this->goal_type === 'weight_loss') {
            $currentWeight = $this->user->bodyMetrics()->latest()->first()?->weight_kg;
            $startWeight = $this->user->bodyMetrics()->where('measured_at', '<=', $this->start_date)->latest()->first()?->weight_kg;

            if ($currentWeight && $startWeight) {
                $totalLoss = $startWeight - $this->target_value;
                $currentLoss = $startWeight - $currentWeight;

                return $totalLoss > 0 ? min(round(($currentLoss / $totalLoss) * 100), 100) : 0;
            }
        }

        return 0;
    }
}
