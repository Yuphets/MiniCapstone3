<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'calorie_goal',
        'protein_goal',
        'carbs_goal',
        'fats_goal',
    ];

    protected $casts = [
        'calorie_goal' => 'integer',
        'protein_goal' => 'integer',
        'carbs_goal' => 'integer',
        'fats_goal' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
