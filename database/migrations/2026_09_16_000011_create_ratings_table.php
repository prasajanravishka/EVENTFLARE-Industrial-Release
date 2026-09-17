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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id', 50);
            $table->foreign('booking_id')->references('BookingID')->on('bookings')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->tinyInteger('rating');
            $table->tinyInteger('rating_quality')->nullable();
            $table->tinyInteger('rating_punctuality')->nullable();
            $table->tinyInteger('rating_communication')->nullable();
            $table->tinyInteger('rating_value')->nullable();
            $table->json('photos')->nullable();
            $table->string('review_title', 255)->nullable();
            $table->text('review_text')->nullable();
            $table->text('supplier_reply')->nullable();
            $table->timestamp('supplier_replied_at')->nullable();
            $table->enum('admin_status', ['approved', 'pending', 'hidden'])->default('approved');
            $table->unique(['booking_id', 'supplier_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
