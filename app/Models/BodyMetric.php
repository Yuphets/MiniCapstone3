<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'measured_at',
        'weight_kg',
        'body_fat_pct',
        'waist_cm',
        'bmi'
    ];

    protected $casts = [
        'measured_at' => 'date',
        'weight_kg' => 'decimal:2',
        'body_fat_pct' => 'decimal:2',
        'waist_cm' => 'decimal:2',
        'bmi' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Automatically calculate BMI when weight is set
    public function setWeightKgAttribute($value)
    {
        $this->attributes['weight_kg'] = $value;

        if ($this->user && $this->user->height_cm) {
            $heightInMeters = $this->user->height_cm / 100;
            $this->attributes['bmi'] = $value / ($heightInMeters * $heightInMeters);
        }
    }

    // Scope for latest metrics
    public function scopeLatest($query)
    {
        return $query->orderBy('measured_at', 'desc');
    }

    // Get weight change from previous measurement
    public function getWeightChangeAttribute()
    {
        $previous = self::where('user_id', $this->user_id)
            ->where('measured_at', '<', $this->measured_at)
            ->latest('measured_at')
            ->first();

        if ($previous) {
            return $this->weight_kg - $previous->weight_kg;
        }

        return 0;
    }
}
