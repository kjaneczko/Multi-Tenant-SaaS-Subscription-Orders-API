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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('tenant_id')->constrained('tenants')->restrictOnDelete();
            $table->enum('plan', ['basic', 'pro', 'enterprise'])->index();
            $table->enum('interval', ['monthly', 'yearly'])->index();
            $table->enum('status', ['active', 'past_due', 'cancelled'])->index();
            $table->dateTime('current_period_start');
            $table->dateTime('current_period_end');
            $table->dateTime('cancelled_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
