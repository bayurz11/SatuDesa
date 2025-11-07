<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('post_attachments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('post_id')
                ->constrained('posts')
                ->cascadeOnDelete();
            $table->string('display_name', 180);
            $table->string('file_path', 255);
            $table->string('mime_type', 120)->nullable();
            $table->unsignedBigInteger('size_bytes')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['post_id', 'sort_order']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('post_attachments');
    }
};
