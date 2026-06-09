<?php

namespace App\Domains\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApbdesTaxBookEntry extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'fiscal_year_id',
        'realization_id',
        'entry_date',
        'reference_number',
        'tax_type',
        'description',
        'tax_base_amount',
        'withheld_amount',
        'remitted_amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'entry_date' => 'date',
            'tax_base_amount' => 'decimal:2',
            'withheld_amount' => 'decimal:2',
            'remitted_amount' => 'decimal:2',
        ];
    }

    public function fiscalYear(): BelongsTo
    {
        return $this->belongsTo(ApbdesFiscalYear::class, 'fiscal_year_id');
    }

    public function realization(): BelongsTo
    {
        return $this->belongsTo(ApbdesRealization::class, 'realization_id');
    }
}
