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
        if (!Schema::hasTable('parking_websites_compare_prices')) {
            return;
        }

        if (!Schema::hasColumn('parking_websites_compare_prices', 'parking_subtype')) {
            Schema::table('parking_websites_compare_prices', function (Blueprint $table) {
                $table->string('parking_subtype')->nullable()->after('parking_type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('parking_websites_compare_prices') && Schema::hasColumn('parking_websites_compare_prices', 'parking_subtype')) {
            Schema::table('parking_websites_compare_prices', function (Blueprint $table) {
                $table->dropColumn('parking_subtype');
            });
        }
    }
};
