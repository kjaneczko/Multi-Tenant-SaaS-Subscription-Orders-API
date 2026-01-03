<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('tenant_id')->constrained('tenants')->restrictOnDelete();

            $table->string('entity_type', 50);   // np. 'order', 'subscription'
            $table->uuid('entity_id');           // id encji

            $table->string('external_id')->unique();
            $table->string('status'); // ['new', 'pending', 'paid', 'cancelled']
            $table->string('provider', 50);
            $table->string('reference', 100)->nullable();
            $table->unsignedInteger('amount_cents');
            $table->char('currency', 3);
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
            $table->index(['tenant_id', 'status']);
            $table->index(['tenant_id', 'created_at']);
            $table->index(['entity_type', 'entity_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
