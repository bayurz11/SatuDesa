<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('galleries')) {
            return;
        }

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('village_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->string('cover_image_path')->nullable();
            $table->string('location_name')->nullable();
            $table->unsignedInteger('photo_count')->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('draft');
            $table->date('gallery_date')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['village_id', 'status']);
            $table->index(['village_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};
