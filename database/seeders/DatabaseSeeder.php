<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ActivityMaster;
use App\Models\FoodItem;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample user
        $user = User::create([
            'username' => 'demo',
            'email' => 'demo@nutriquest.com',
            'password' => Hash::make('password'),
            'full_name' => 'Demo User',
            'height_cm' => 170,
            'weight_kg' => 70,
        ]);

        echo "User created: demo@nutriquest.com / password\n";

        // Create sample activities
        $activities = [
            [
                'name' => 'Running',
                'activity_type' => 'cardio',
                'calories_per_min' => 10.0,
                'default_duration_min' => 30
            ],
            [
                'name' => 'Cycling',
                'activity_type' => 'cardio',
                'calories_per_min' => 8.0,
                'default_duration_min' => 45
            ],
            [
                'name' => 'Weight Training',
                'activity_type' => 'strength',
                'calories_per_min' => 6.0,
                'default_duration_min' => 60
            ],
            [
                'name' => 'Swimming',
                'activity_type' => 'cardio',
                'calories_per_min' => 11.0,
                'default_duration_min' => 30
            ],
            [
                'name' => 'Yoga',
                'activity_type' => 'flexibility',
                'calories_per_min' => 3.0,
                'default_duration_min' => 60
            ],
        ];

        foreach ($activities as $activity) {
            ActivityMaster::create($activity);
        }

        echo "Activities created\n";

        // Create sample food items
        $foods = [
            [
                'name' => 'Chicken Breast',
                'calories' => 165,
                'protein_g' => 31,
                'carbs_g' => 0,
                'fats_g' => 3.6
            ],
            [
                'name' => 'Brown Rice',
                'calories' => 112,
                'protein_g' => 2.6,
                'carbs_g' => 23,
                'fats_g' => 0.9
            ],
            [
                'name' => 'Broccoli',
                'calories' => 34,
                'protein_g' => 2.8,
                'carbs_g' => 7,
                'fats_g' => 0.4
            ],
            [
                'name' => 'Banana',
                'calories' => 105,
                'protein_g' => 1.3,
                'carbs_g' => 27,
                'fats_g' => 0.4
            ],
            [
                'name' => 'Eggs',
                'calories' => 155,
                'protein_g' => 13,
                'carbs_g' => 1.1,
                'fats_g' => 11
            ],
        ];

        foreach ($foods as $food) {
            FoodItem::create($food);
        }

        echo "Food items created\n";
        echo "Seeding completed successfully!\n";
    }
}
