<?php

namespace App\Domains\Budget\Models;

use App\Domains\Village\Models\Village;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApbdesFundingSource extends Model
{
    protected $fillable = [
        'village_id',
        'code',
        'name',
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

    public function budgetLines(): HasMany
    {
        return $this->hasMany(ApbdesBudgetLine::class, 'funding_source_id');
    }
}
