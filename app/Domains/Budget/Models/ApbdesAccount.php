<?php

namespace App\Domains\Budget\Models;

use App\Domains\Village\Models\Village;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApbdesAccount extends Model
{
    protected $fillable = [
        'village_id',
        'parent_id',
        'code',
        'name',
        'type',
        'level',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function budgetLines(): HasMany
    {
        return $this->hasMany(ApbdesBudgetLine::class, 'account_id');
    }
}
