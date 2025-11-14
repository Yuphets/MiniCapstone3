<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if columns exist before adding them
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->after('id');
            }

            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('name');
            }

            if (!Schema::hasColumn('users', 'height_cm')) {
                $table->decimal('height_cm', 5, 2)->nullable()->after('password');
            }

            if (!Schema::hasColumn('users', 'weight_kg')) {
                $table->decimal('weight_kg', 5, 2)->nullable()->after('height_cm');
            }

            if (!Schema::hasColumn('users', 'is_admin')) {
                $table->boolean('is_admin')->default(false)->after('weight_kg');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Only drop columns if they exist
            $columns = ['name', 'username', 'height_cm', 'weight_kg', 'is_admin'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
