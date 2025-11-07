<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('category_id')
                ->nullable()
                ->constrained('post_categories')
                ->nullOnDelete();

            // konten umum
            $table->enum('content_type', ['announcement', 'news'])->default('announcement');
            $table->string('title', 200);
            $table->string('slug', 220)->unique();
            $table->text('summary');
            $table->longText('body_html');

            // atribut pengumuman
            $table->string('location', 200)->nullable();
            $table->string('organizer', 160)->nullable();

            // atribut berita
            $table->string('author_name', 160)->nullable();
            $table->unsignedSmallInteger('read_minutes')->nullable();
            $table->string('source_url', 255)->nullable();

            // cover & jadwal
            $table->string('cover_path', 255)->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->boolean('is_all_day')->default(false);

            // publikasi & audit
            $table->enum('status', ['draft', 'scheduled', 'published', 'archived'])->default('draft');
            $table->dateTime('published_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            // index
            $table->index(['category_id']);
            $table->index(['content_type']);
            $table->index(['status']);
            $table->index(['published_at']);
            $table->index(['start_at']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
