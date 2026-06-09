<?php

namespace App\Domains\Village\Models;

use App\Domains\Post\Models\Post;
use App\Domains\Post\Models\PostCategory;
use App\Domains\Potential\Models\Potential;
use App\Domains\Potential\Models\PotentialCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Village extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'district',
        'regency',
        'province',
        'postal_code',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function postCategories(): HasMany
    {
        return $this->hasMany(PostCategory::class);
    }

    public function potentials(): HasMany
    {
        return $this->hasMany(Potential::class);
    }

    public function potentialCategories(): HasMany
    {
        return $this->hasMany(PotentialCategory::class);
    }
}
