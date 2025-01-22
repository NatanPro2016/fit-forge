<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('firends', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('requester');
            $table->unsignedBigInteger('receiver');
            $table->foreign('requester')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firends');
    }
};
