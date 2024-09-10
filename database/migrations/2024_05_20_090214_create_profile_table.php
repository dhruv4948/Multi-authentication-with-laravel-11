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
        Schema::create('profile', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('Number');
            $table->date('DOB');
            $table->string('Gender');
            $table->string('Education');
            $table->json('Interest');
            $table->string('Address');
            $table->string('City');
            $table->string('Country');
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile');
    }
};
