<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'category',
        'serving_qty',
        'serving_unit',
        'calories',
        'protein_g',
        'carbs_g',
        'fats_g',
        'notes'
    ];

    protected $casts = [
        'calories' => 'decimal:2',
        'protein_g' => 'decimal:2',
        'carbs_g' => 'decimal:2',
        'fats_g' => 'decimal:2',
        'serving_qty' => 'decimal:3'
    ];

    public function mealItems()
    {
        return $this->hasMany(MealItem::class);
    }
}
