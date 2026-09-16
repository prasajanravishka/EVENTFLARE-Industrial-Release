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
        Schema::create('booking_services', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id', 50);
            $table->foreign('booking_id')->references('BookingID')->on('bookings')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services', 'service_id')->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
            $table->foreignId('listing_id')->nullable()->constrained('supplier_listings', 'listing_id')->onDelete('set null');
            $table->text('custom_notes')->nullable();
            $table->decimal('assigned_cost', 10, 2)->default(0.00);
            $table->enum('status', ['requested', 'confirmed', 'declined'])->default('confirmed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_services');
    }
};
