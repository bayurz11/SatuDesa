<?php

namespace App\Domains\Post\Models;

use App\Domains\Analytics\Models\PostView;
use App\Domains\User\Models\User;
use App\Domains\Village\Models\Village;
use App\Support\UploadStorage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public const TYPE_NEWS = 'news';
    public const TYPE_ANNOUNCEMENT = 'announcement';

    protected $fillable = [
        'village_id',
        'category_id',
        'author_id',
        'type',
        'title',
        'slug',
        'excerpt',
        'content',
        'content_raw',
        'content_safe',
        'cover_image_path',
        'cover_image_alt',
        'cover_image_caption',
        'is_featured',
        'meta_title',
        'meta_description',
        'tags',
        'status',
        'published_at',
        'event_at',
        'event_location',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'event_at' => 'datetime',
            'is_featured' => 'boolean',
            'tags' => 'array',
        ];
    }

    public function scopeContentType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeNews($query)
    {
        return $query->where('type', self::TYPE_NEWS);
    }

    public function scopeAnnouncements($query)
    {
        return $query->where('type', self::TYPE_ANNOUNCEMENT);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at');
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        if (! $this->cover_image_path) {
            return null;
        }

        return UploadStorage::url($this->cover_image_path);
    }

    public function getAnnouncementDateAttribute()
    {
        return $this->event_at ?: $this->published_at;
    }

    public function getEditorContentAttribute(): string
    {
        return (string) ($this->content_raw ?? $this->content ?? '');
    }

    public function getDisplayContentAttribute(): string
    {
        return (string) ($this->content_safe ?? $this->content ?? '');
    }

    public function getPreviewContentTextAttribute(): string
    {
        return trim(strip_tags($this->display_content ?: $this->editor_content));
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
