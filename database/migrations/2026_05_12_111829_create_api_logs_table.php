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
        Schema::create('api_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['incoming', 'outgoing']);
            // incoming = client dashboard → senior API
            // outgoing = senior API → Gatwick
            $table->string('client_name')->nullable();
            $table->string('license_key')->nullable();
            $table->integer('flights_requested')->default(0);
            $table->integer('flights_found')->default(0);
            $table->enum('status', ['success', 'failed'])->default('success');
            $table->string('error_message')->nullable();
            $table->integer('response_time_ms')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->index('type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_logs');
    }
};
