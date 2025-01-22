<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**4
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workout_plans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('duration');
            $table->integer('incrimination');
            $table->boolean('Mon')->nullable(true);
            $table->boolean('Tues')->nullable(true);
            $table->boolean('Wed')->nullable(true);
            $table->boolean('Thurs')->nullable(true);
            $table->boolean('Fri')->nullable(true);
            $table->boolean('Sat')->nullable(true);
            $table->boolean('Sun')->nullable(true);
            $table->foreignId('plan_id')->constrained();
            $table->foreignId('workout_id')->constrained();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_plans');
    }
};
