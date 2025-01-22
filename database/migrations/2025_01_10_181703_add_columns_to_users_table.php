<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * users ,

     */

    //      uid,

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable(true);
            $table->string('profile')->nullable(true);
            $table->string('profile-hash')->nullable(true);
            $table->string('sex');
            $table->string('height')->nullable(true);
            $table->integer('age')->nullable(true);
            $table->integer('weight')->nullable(true);
            ;

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
