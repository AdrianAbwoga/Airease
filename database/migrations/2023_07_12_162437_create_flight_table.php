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
        
            Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('departure_location');
            $table->string('destination');
            $table->integer('number_of_users');
            $table->string('travel_class');
            $table->boolean('is_round_trip');
            $table->date('departure_date');
            $table->date('return_date')->nullable();
            $table->timestamps();
      
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};