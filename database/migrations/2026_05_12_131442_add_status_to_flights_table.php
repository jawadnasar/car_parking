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
        if (!Schema::hasColumn('flights', 'status')) {
            Schema::table('flights', function (Blueprint $table) {
                $table->string('status')->nullable()->after('time');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('flights', 'status')) {
            Schema::table('flights', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};