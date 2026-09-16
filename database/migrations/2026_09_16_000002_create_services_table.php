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
        Schema::create('services', function (Blueprint $table) {
            $table->id('service_id');
            $table->foreignId('event_type_id')->constrained('event_types', 'event_type_id')->onDelete('cascade');
            $table->string('service_name', 150);
            $table->text('description');
            $table->integer('priority_rank')->default(0);
            $table->boolean('is_required')->default(false);
            $table->integer('typical_capacity')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
