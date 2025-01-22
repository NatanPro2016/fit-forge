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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->longText('message');
            $table->text('image')->nullable(true);
            $table->text('video')->nullable(true);
            $table->foreignId('message_id')->nullable(true)->constrained();
            $table->unsignedBigInteger('sender_id');
            $table->string('sender_type');          
            $table->unsignedBigInteger('recipient_id'); 
            $table->string('recipient_type');
            $table->foreignId('chat_id')->constrained();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
