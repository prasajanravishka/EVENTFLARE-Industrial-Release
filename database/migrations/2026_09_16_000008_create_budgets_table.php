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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('user_name', 50)->nullable();
            $table->string('booking_id', 50)->nullable();
            $table->decimal('total_budget', 10, 2);
            $table->decimal('food_budget', 10, 2);
            $table->decimal('buffet_cost', 10, 2);
            $table->decimal('beverages_cost', 10, 2);
            $table->decimal('desserts_cost', 10, 2);
            $table->decimal('snacks_cost', 10, 2);
            $table->decimal('total_spent', 10, 2);
            $table->decimal('remaining_budget', 10, 2);
            $table->decimal('variance', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
