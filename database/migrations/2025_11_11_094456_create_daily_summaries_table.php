<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('daily_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('summary_date');
            $table->decimal('calories_in', 9, 2)->default(0);
            $table->decimal('calories_out', 9, 2)->default(0);
            $table->integer('steps')->default(0);
            $table->decimal('net_calories', 9, 2)->storedAs('calories_in - calories_out');
            $table->timestamps();

            $table->unique(['user_id', 'summary_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('daily_summaries');
    }
};
