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
        Schema::table('event_types', function (Blueprint $table) {
            $table->string('badge', 100)->nullable()->after('image_url');
            $table->string('chips', 255)->nullable()->after('badge');
            $table->string('vendor_count_label', 100)->nullable()->after('chips');
            $table->string('accent_color', 30)->nullable()->after('vendor_count_label');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_types', function (Blueprint $table) {
            $table->dropColumn(['badge', 'chips', 'vendor_count_label', 'accent_color']);
        });
    }
};
