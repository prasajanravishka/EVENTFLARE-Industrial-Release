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
        Schema::create('supplier_listings', function (Blueprint $table) {
            $table->id('listing_id');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services', 'service_id')->onDelete('cascade');
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->enum('price_type', ['total_package', 'per_person', 'per_hour', 'per_day'])->default('total_package');
            $table->integer('capacity')->nullable();
            $table->string('image_url', 255)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_listings');
    }
};
