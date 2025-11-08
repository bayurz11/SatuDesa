<?php

namespace App\Domains\Post\Models;

use Illuminate\Support\Str;
use App\Domains\Tag\Models\Tag;
use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Domains\Category\Models\Category;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'category_id',
        'content_type',     // 'announcement', 'news', 'potential'
        'title',
        'slug',
        'summary',
        'body_html',
        'location',
        'organizer',        // untuk pengumuman
        'author_name',
        'read_minutes',     // untuk berita
        'cover_path',
        'start_at',
        'end_at',
        'is_all_day',
        'status',           // draft, published, archived
        'published_at',
        'source_url',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_all_day'   => 'boolean',
        'read_minutes' => 'integer',
        'start_at'     => 'datetime',
        'end_at'       => 'datetime',
        'published_at' => 'datetime',
    ];

    /* =======================================
     |               RELATIONS
     ======================================= */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /* =======================================
     |               SCOPES
     ======================================= */
    public function scopePublished($q)
    {
        return $q->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeDraft($q)
    {
        return $q->where('status', 'draft');
    }

    public function scopeNews($q)
    {
        return $q->where('content_type', 'news');
    }

    public function scopeAnnouncements($q)
    {
        return $q->where('content_type', 'announcement');
    }

    public function scopePotentials($q)
    {
        return $q->where('content_type', 'potential');
    }

    public function scopeSearch($q, ?string $term)
    {
        if (!$term) return $q;

        return $q->where(function ($w) use ($term) {
            $w->where('title', 'like', "%{$term}%")
                ->orWhere('summary', 'like', "%{$term}%")
                ->orWhere('body_html', 'like', "%{$term}%");
        });
    }

    /* =======================================
     |               ACCESSORS
     ======================================= */
    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover_path ? Storage::url($this->cover_path) : asset('public/img/default-cover.jpg');
    }

    public function getIsPastEventAttribute(): bool
    {
        if ($this->content_type !== 'announcement') return false;
        $end = $this->end_at ?? $this->start_at;
        return $end ? now()->gt($end) : false;
    }

    /* =======================================
     |               BOOT
     ======================================= */
    protected static function booted()
    {
        static::creating(function (self $post) {
            if (blank($post->slug) && filled($post->title)) {
                $post->slug = Str::slug($post->title);
            }

            $post->status = $post->status ?? 'draft';
        });

        static::saving(function (self $post) {
            if (blank($post->slug) && filled($post->title)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }
}
