<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'meal_log_id',
        'food_item_id',
        'quantity',
        'calories',
        'protein_g',
        'carbs_g',
        'fats_g'
    ];

    public function mealLog()
    {
        return $this->belongsTo(MealLog::class);
    }

    public function foodItem()
    {
        return $this->belongsTo(FoodItem::class);
    }
}
