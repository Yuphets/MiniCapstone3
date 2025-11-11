<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('food_items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('brand', 150)->nullable();
            $table->string('category', 100)->nullable();
            $table->decimal('serving_qty', 8, 3)->default(100.0);
            $table->string('serving_unit', 50)->default('g');
            $table->decimal('calories', 7, 2);
            $table->decimal('protein_g', 6, 2)->default(0);
            $table->decimal('carbs_g', 6, 2)->default(0);
            $table->decimal('fats_g', 6, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['name', 'brand']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_items');
    }
};
