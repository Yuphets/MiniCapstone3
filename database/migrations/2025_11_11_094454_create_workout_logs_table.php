<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('workout_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('activity_id')->nullable()->constrained('activities_master')->onDelete('set null');
            $table->date('activity_date');
            $table->time('start_time')->nullable();
            $table->integer('duration_min');
            $table->decimal('calories_burned', 7, 2);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'activity_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('workout_logs');
    }
};
