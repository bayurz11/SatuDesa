<?php

namespace App\Domains\Category\Models;

use App\Domains\User\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes, HasUlids;

    protected $table = 'posts';

    protected $fillable = [
        'category_id',
        'content_type', // announcement | news
        'title',
        'slug',
        'summary',
        'body_html',
        'location',
        'organizer',          // announcement
        'author_name',
        'read_minutes',    // news
        'cover_path',
        'start_at',
        'end_at',
        'is_all_day',
        'status',
        'published_at',
        'source_url',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_all_day'    => 'boolean',
        'read_minutes'  => 'integer',
        'start_at'      => 'datetime',
        'end_at'        => 'datetime',
        'published_at'  => 'datetime',
    ];

    // ========== Relasi ==========
    // public function category()
    // {
    //     return $this->belongsTo(PostCategory::class, 'category_id');
    // }

    // public function tags()
    // {
    //     return $this->belongsToMany(Tag::class, 'post_tag');
    // }

    // public function attachments()
    // {
    //     return $this->hasMany(PostAttachment::class, 'post_id');
    // }

    // public function galleries()
    // {
    //     return $this->hasMany(PostGallery::class, 'post_id');
    // }

    // (Opsional) relasi ke User bila perlu
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ========== Scopes ==========
    public function scopePublished($q)
    {
        return $q->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeScheduled($q)
    {
        return $q->where('status', 'scheduled');
    }
    public function scopeNews($q)
    {
        return $q->where('content_type', 'news');
    }
    public function scopeAnnouncements($q)
    {
        return $q->where('content_type', 'announcement');
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

    public function scopeFilterCategory($q, $categoryId)
    {
        if ($categoryId) $q->where('category_id', $categoryId);
        return $q;
    }

    public function scopeWithBasic($q)
    {
        return $q->with(['category:id,name,slug', 'tags:id,name,slug']);
    }

    // ========== Accessors ==========
    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover_path ? Storage::url($this->cover_path) : null;
    }

    public function getIsPastEventAttribute(): bool
    {
        if ($this->content_type !== 'announcement') return false;
        $end = $this->end_at ?? $this->start_at;
        return $end ? now()->gt($end) : false;
    }

    // ========== Events ==========
    protected static function booted()
    {
        static::saving(function (self $model) {
            if (blank($model->slug) && filled($model->title)) {
                $model->slug = Str::slug($model->title);
            }
            // Normalisasi enum sederhana
            $model->content_type = $model->content_type ?: 'announcement';
        });
    }
}
