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
        Schema::table('camping_sites', function (Blueprint $table) {
            $table->json('facilities')->nullable()->after('is_prime_location');
            $table->string('map_url')->nullable()->after('facilities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('camping_sites', function (Blueprint $table) {
            $table->dropColumn(['facilities', 'map_url']);
        });
    }
};
