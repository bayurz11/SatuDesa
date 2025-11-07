<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('post_galleries', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('post_id')
                ->constrained('posts')
                ->cascadeOnDelete();
            $table->string('image_path', 255);
            $table->string('caption', 200)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['post_id', 'sort_order']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('post_galleries');
    }
};
