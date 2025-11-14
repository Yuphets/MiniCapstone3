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
        'notes',
        'total_calories'
    ];

    protected $casts = [
        'meal_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mealItems()
    {
        return $this->hasMany(MealItem::class);
    }

    // Add this method to fix the relationship issue
    public function foodItems()
    {
        return $this->hasManyThrough(FoodItem::class, MealItem::class, 'meal_log_id', 'id', 'id', 'food_item_id');
    }
}
