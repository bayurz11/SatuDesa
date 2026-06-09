<?php

namespace App\Domains\Budget\Models;

use App\Domains\Village\Models\Village;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApbdesFiscalYear extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'village_id',
        'year',
        'title',
        'status',
        'start_date',
        'end_date',
        'apbdes_regulation_number',
        'apbdes_regulation_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'apbdes_regulation_date' => 'date',
        ];
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function budgetLines(): HasMany
    {
        return $this->hasMany(ApbdesBudgetLine::class, 'fiscal_year_id');
    }
}
