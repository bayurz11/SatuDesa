<?php

namespace App\Domains\Post\Models;

use App\Domains\Analytics\Models\PostView;
use App\Domains\User\Models\User;
use App\Domains\Village\Models\Village;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'village_id',
        'category_id',
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image_path',
        'cover_image_alt',
        'cover_image_caption',
        'is_featured',
        'meta_title',
        'meta_description',
        'tags',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
            'tags' => 'array',
        ];
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        if (! $this->cover_image_path) {
            return null;
        }

        return '/storage/' . ltrim($this->cover_image_path, '/');
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function views(): HasMany
    {
        return $this->hasMany(PostView::class);
    }
}
