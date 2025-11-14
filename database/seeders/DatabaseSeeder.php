<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ActivityMaster;
use App\Models\FoodItem;
use App\Models\BodyMetric;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@nutriquest.com',
            'password' => Hash::make('admin123'),
            'height_cm' => 175,
            'weight_kg' => 70,
            'is_admin' => true,
        ]);

        // Create initial body metric for admin
        if ($admin->height_cm && $admin->weight_kg) {
            $heightInMeters = $admin->height_cm / 100;
            $bmi = $admin->weight_kg / ($heightInMeters * $heightInMeters);

            BodyMetric::create([
                'user_id' => $admin->id,
                'measured_at' => now(),
                'weight_kg' => $admin->weight_kg,
                'body_fat_pct' => null,
                'waist_cm' => null,
                'bmi' => round($bmi, 2)
            ]);
        }

        // Create sample user
        $user = User::create([
            'name' => 'Demo User',
            'username' => 'demo',
            'email' => 'demo@nutriquest.com',
            'password' => Hash::make('password'),
            'height_cm' => 170,
            'weight_kg' => 70,
            'is_admin' => false,
        ]);

        // Create initial body metric for demo user
        if ($user->height_cm && $user->weight_kg) {
            $heightInMeters = $user->height_cm / 100;
            $bmi = $user->weight_kg / ($heightInMeters * $heightInMeters);

            BodyMetric::create([
                'user_id' => $user->id,
                'measured_at' => now(),
                'weight_kg' => $user->weight_kg,
                'body_fat_pct' => null,
                'waist_cm' => null,
                'bmi' => round($bmi, 2)
            ]);
        }

        echo "Admin created: admin@nutriquest.com / admin123\n";
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
                'serving_qty' => 1,
                'serving_unit' => 'piece',
                'calories' => 165,
                'protein_g' => 31,
                'carbs_g' => 0,
                'fats_g' => 3.6
            ],
            [
                'name' => 'Brown Rice',
                'serving_qty' => 1,
                'serving_unit' => 'cup',
                'calories' => 112,
                'protein_g' => 2.6,
                'carbs_g' => 23,
                'fats_g' => 0.9
            ],
            [
                'name' => 'Broccoli',
                'serving_qty' => 1,
                'serving_unit' => 'cup',
                'calories' => 34,
                'protein_g' => 2.8,
                'carbs_g' => 7,
                'fats_g' => 0.4
            ],
            [
                'name' => 'Banana',
                'serving_qty' => 1,
                'serving_unit' => 'piece',
                'calories' => 105,
                'protein_g' => 1.3,
                'carbs_g' => 27,
                'fats_g' => 0.4
            ],
            [
                'name' => 'Eggs',
                'serving_qty' => 1,
                'serving_unit' => 'piece',
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
