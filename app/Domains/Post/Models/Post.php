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
        'content_type',
        'title',
        'slug',
        'summary',
        'body_html',

        // announcement
        'location',
        'organizer',
        'start_at',
        'end_at',
        'is_all_day',

        // news
        'author_name',
        'read_minutes',
        'source_url',

        // media & publish
        'cover_path',
        'status',
        'published_at',

        // ===== POTENSI (kolom eksplisit) =====
        'potensi_category',
        'latitude',
        'longitude',
        'address',
        'contact_name',
        'contact_phone',
        'price_min',
        'price_max',
        'external_link',

        // fleksibel
        'meta',
    ];

    protected $casts = [
        'is_all_day'   => 'boolean',
        'read_minutes' => 'integer',
        'start_at'     => 'datetime',
        'end_at'       => 'datetime',
        'published_at' => 'datetime',

        // potensi
        'latitude'     => 'decimal:6',
        'longitude'    => 'decimal:6',

        // fleksibel
        'meta'         => 'array',
    ];

    /* =========================
     * Relations
     * =======================*/
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

    /* =========================
     * Scopes
     * =======================*/
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
    public function scopeDraft($q)
    {
        return $q->where('status', 'draft');
    }
    public function scopeArchived($q)
    {
        return $q->where('status', 'archived');
    }

    public function scopeNews($q)
    {
        return $q->where('content_type', 'news');
    }
    public function scopeAnnouncements($q)
    {
        return $q->where('content_type', 'announcement');
    }
    public function scopePotensi($q)
    {
        return $q->where('content_type', 'potensi');
    }

    public function scopeCategoryPotensi($q, $cat)
    {
        return $q->where('content_type', 'potensi')->where('potensi_category', $cat);
    }

    /**
     * Fulltext sederhana: cari di field umum + field potensi.
     */
    public function scopeSearch($q, ?string $term)
    {
        if (blank($term)) return $q;

        return $q->where(function ($w) use ($term) {
            $w->where('title', 'like', "%{$term}%")
                ->orWhere('summary', 'like', "%{$term}%")
                ->orWhere('body_html', 'like', "%{$term}%")
                ->orWhere('organizer', 'like', "%{$term}%")
                ->orWhere('author_name', 'like', "%{$term}%")
                // potensi
                ->orWhere('potensi_category', 'like', "%{$term}%")
                ->orWhere('address', 'like', "%{$term}%")
                ->orWhere('contact_name', 'like', "%{$term}%")
                ->orWhere('contact_phone', 'like', "%{$term}%");
        });
    }

    /* =========================
     * Accessors / Helpers
     * =======================*/
    public function getCoverUrlAttribute(): ?string
    {
        // Jika cover disimpan di disk 'public' (Storage::url) → pastikan config/filesystems benar.
        return $this->cover_path
            ? (Str::startsWith($this->cover_path, ['http://', 'https://'])
                ? $this->cover_path
                : (Storage::disk(config('filesystems.default'))->exists($this->cover_path)
                    ? Storage::url($this->cover_path)
                    : asset($this->cover_path)))
            : asset('public/img/default-cover.jpg');
    }

    public function getIsPastEventAttribute(): bool
    {
        if ($this->content_type !== 'announcement') return false;
        $end = $this->end_at ?? $this->start_at;
        return $end ? now()->gt($end) : false;
    }

    public function isPotensi(): bool
    {
        return $this->content_type === 'potensi';
    }

    public function hasCoordinates(): bool
    {
        return !is_null($this->latitude) && !is_null($this->longitude);
    }

    public function getMapEmbedUrlAttribute(): ?string
    {
        if (!$this->hasCoordinates()) return null;
        return "https://maps.google.com/maps?q={$this->latitude},{$this->longitude}&z=13&output=embed";
    }

    /* =========================
     * Boot events
     * =======================*/
    protected static function booted()
    {
        static::creating(function (self $post) {
            if (blank($post->slug) && filled($post->title)) {
                $post->slug = Str::slug($post->title);
            }
            $post->status = $post->status ?? 'draft';

            // inisialisasi meta biar array
            if (is_null($post->meta)) {
                $post->meta = [];
            }
        });

        static::saving(function (self $post) {
            if (blank($post->slug) && filled($post->title)) {
                $post->slug = Str::slug($post->title);
            }

            // jaga konsistensi price_max >= price_min
            if (!is_null($post->price_min) && !is_null($post->price_max) && $post->price_max < $post->price_min) {
                $post->price_max = $post->price_min;
            }
        });
    }
}
