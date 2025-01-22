<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    //      tanners,
// tid,
// name ,
// email,
// sex,
// name ,
// username,
// password
// profile,
// profile hash,
// email,
// sex,
// age ,
// height ,
// weight ,
// register date 
    public function up(): void
    {
        Schema::create('tranners', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('sex');
            $table->integer('age');
            $table->string('profile')->nullable(true);
            $table->string('profilehash')->nullable(true);
            $table->string('height')->nullable(true);
            $table->string('weight')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tranners');
    }
};
