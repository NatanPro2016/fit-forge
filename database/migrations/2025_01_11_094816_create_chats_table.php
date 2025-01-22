<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('sender_id'); // ID of the sender
            $table->string('sender_type');          // "App\Models\User", "App\Models\Trainer", or "App\Models\Admin"
            $table->unsignedBigInteger('recipient_id'); // ID of the recipient
            $table->string('recipient_type');          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
