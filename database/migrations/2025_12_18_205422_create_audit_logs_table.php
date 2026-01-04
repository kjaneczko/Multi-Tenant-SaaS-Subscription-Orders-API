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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // $table->foreignUuid('tenant_id')->constrained('tenants')->restrictOnDelete();
            $table->uuid('tenant_id')->nullable();
            // $table->foreignUuid('actor_user_id')->constrained('users')->nullOnDelete();
            $table->uuid('actor_user_id')->nullable();
            $table->string('category');
            $table->string('action');
            $table->string('entity_type');
            $table->uuid('entity_id')->nullable();
            $table->json('payload');
            $table->boolean('success');
            $table->integer('duration_ms');
            $table->string('error_type')->nullable();
            $table->string('error_message')->nullable();
            $table->string('request_id');
            $table->string('ip');
            $table->string('user_agent');
            $table->timestamp('created_at')->useCurrent();
            $table->index(['tenant_id', 'actor_user_id']);
            $table->index(['tenant_id', 'created_at']);
            $table->index(['tenant_id', 'entity_type', 'entity_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
