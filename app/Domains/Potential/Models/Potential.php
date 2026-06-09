<?php

namespace App\Domains\Potential\Models;

use App\Domains\Village\Models\Village;
use App\Support\UploadStorage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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
        'opportunities',
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

        return Storage::disk(UploadStorage::disk())->url($this->cover_image_path);
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
