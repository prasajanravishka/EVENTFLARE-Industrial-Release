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
        Schema::create('platform_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('booking_id', 50)->nullable();
            $table->tinyInteger('nps_score')->nullable(); // 0-10 Net Promoter Score
            $table->tinyInteger('platform_rating')->nullable(); // 1-5 Star Rating
            $table->string('category', 50)->default('general'); // booking_wizard, concierge, marketplace, website, general
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_feedback');
    }
};
