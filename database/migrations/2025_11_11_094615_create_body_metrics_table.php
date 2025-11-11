<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('body_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('measured_at');
            $table->decimal('weight_kg', 6, 2);
            $table->decimal('body_fat_pct', 5, 2)->nullable();
            $table->decimal('waist_cm', 6, 2)->nullable();
            $table->decimal('bmi', 5, 2);
            $table->timestamps();

            $table->index(['user_id', 'measured_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('body_metrics');
    }
};
