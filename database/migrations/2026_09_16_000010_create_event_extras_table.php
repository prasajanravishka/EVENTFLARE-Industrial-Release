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
        Schema::create('event_extras', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id', 50)->unique();
            $table->foreign('booking_id')->references('BookingID')->on('bookings')->onDelete('cascade');
            $table->string('equipment', 50)->nullable();
            $table->string('food_style', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_extras');
    }
};
