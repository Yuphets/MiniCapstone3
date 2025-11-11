<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('activities_master', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('activity_type', 50);
            $table->decimal('calories_per_min', 7, 3);
            $table->integer('default_duration_min')->default(30);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('activities_master');
    }
};
