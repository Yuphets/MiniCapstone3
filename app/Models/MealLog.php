<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'meal_date',
        'meal_type',
        'total_calories',
        'notes'
    ];

    protected $casts = [
        'meal_date' => 'date',
        'total_calories' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mealItems()
    {
        return $this->hasMany(MealItem::class);
    }

    // Helper method to calculate total nutrition
    public function getTotalNutritionAttribute()
    {
        return [
            'calories' => $this->mealItems->sum('calories'),
            'protein' => $this->mealItems->sum('protein_g'),
            'carbs' => $this->mealItems->sum('carbs_g'),
            'fats' => $this->mealItems->sum('fats_g'),
        ];
    }
}
