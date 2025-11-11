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

    protected $casts = [
        'quantity' => 'decimal:3',
        'calories' => 'decimal:2',
        'protein_g' => 'decimal:2',
        'carbs_g' => 'decimal:2',
        'fats_g' => 'decimal:2'
    ];

    public function mealLog()
    {
        return $this->belongsTo(MealLog::class);
    }

    public function foodItem()
    {
        return $this->belongsTo(FoodItem::class);
    }

    // Automatically calculate nutrition when quantity changes
    public function setQuantityAttribute($value)
    {
        $this->attributes['quantity'] = $value;

        if ($this->foodItem) {
            $ratio = $value / $this->foodItem->serving_qty;
            $this->attributes['calories'] = $this->foodItem->calories * $ratio;
            $this->attributes['protein_g'] = $this->foodItem->protein_g * $ratio;
            $this->attributes['carbs_g'] = $this->foodItem->carbs_g * $ratio;
            $this->attributes['fats_g'] = $this->foodItem->fats_g * $ratio;
        }
    }
}
