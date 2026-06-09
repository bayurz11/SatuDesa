<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->string('visitor_token', 100)->index();
            $table->string('session_id', 120)->nullable()->index();
            $table->text('referer')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('viewed_at')->index();
            $table->timestamps();

            $table->index(['post_id', 'visitor_token', 'viewed_at'], 'post_views_post_token_viewed_at_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_views');
    }
};
