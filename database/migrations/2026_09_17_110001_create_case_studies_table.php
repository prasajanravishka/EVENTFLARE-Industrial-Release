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
        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_type_id')->nullable();
            $table->string('title');
            $table->string('category_tag')->default('wedding'); // wedding, dj, birthday, hotel, gettogether, corporate
            $table->string('category_label')->nullable();       // e.g. "Coastal & Beachfront"
            $table->string('venue');
            $table->string('event_date')->nullable();
            $table->integer('guests_count')->default(150);
            $table->string('image_url')->nullable();
            $table->string('tagline')->nullable();
            $table->text('summary')->nullable();
            $table->text('quote')->nullable();
            $table->string('client_name')->nullable();
            $table->json('services_delivered')->nullable();
            $table->boolean('is_featured_home')->default(true);
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();

            $table->foreign('event_type_id')
                ->references('event_type_id')
                ->on('event_types')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_studies');
    }
};
