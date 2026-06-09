<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('user_email')->nullable();
            $table->string('category', 100)->index();
            $table->string('level', 50)->default('info')->index();
            $table->string('action', 100)->nullable()->index();
            $table->string('entity_type', 150)->nullable()->index();
            $table->unsignedBigInteger('entity_id')->nullable()->index();
            $table->string('message');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('url')->nullable();
            $table->string('method', 20)->nullable();
            $table->json('context')->nullable();
            $table->timestamp('logged_at')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
