<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_visits', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_token', 100)->index();
            $table->string('session_id', 120)->nullable()->index();
            $table->string('path');
            $table->text('url')->nullable();
            $table->text('referer')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('visited_at')->index();
            $table->timestamps();

            $table->index(['visitor_token', 'path', 'visited_at'], 'website_visits_token_path_visited_at_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_visits');
    }
};
