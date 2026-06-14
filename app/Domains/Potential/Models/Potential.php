<?php

namespace App\Domains\Potential\Models;

use App\Domains\Village\Models\Village;
use App\Support\UploadStorage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Potential extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'village_id',
        'category_id',
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
        'potential_type',
        'location_name',
        'address',
        'latitude',
        'longitude',
        'contact_person',
        'contact_phone',
        'facilities',
        'facilities_raw',
        'facilities_safe',
        'opportunities',
        'opportunities_raw',
        'opportunities_safe',
        'development_status',
        'sort_order',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        if (! $this->cover_image_path) {
            return null;
        }

        return UploadStorage::url($this->cover_image_path);
    }

    public function getEditorContentAttribute(): string
    {
        return (string) ($this->content_raw ?? $this->content ?? '');
    }

    public function getDisplayContentAttribute(): string
    {
        return (string) ($this->content_safe ?? $this->content ?? '');
    }

    public function getEditorFacilitiesAttribute(): string
    {
        return (string) ($this->facilities_raw ?? $this->facilities ?? '');
    }

    public function getDisplayFacilitiesAttribute(): string
    {
        return (string) ($this->facilities_safe ?? $this->facilities ?? '');
    }

    public function getEditorOpportunitiesAttribute(): string
    {
        return (string) ($this->opportunities_raw ?? $this->opportunities ?? '');
    }

    public function getDisplayOpportunitiesAttribute(): string
    {
        return (string) ($this->opportunities_safe ?? $this->opportunities ?? '');
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
        return $this->belongsTo(PotentialCategory::class, 'category_id');
    }
}
