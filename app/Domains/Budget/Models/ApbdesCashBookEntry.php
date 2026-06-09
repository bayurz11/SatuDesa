<?php

namespace App\Domains\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApbdesCashBookEntry extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'fiscal_year_id',
        'realization_id',
        'entry_date',
        'reference_number',
        'description',
        'debit_amount',
        'credit_amount',
        'balance',
    ];

    protected function casts(): array
    {
        return [
            'entry_date' => 'date',
            'debit_amount' => 'decimal:2',
            'credit_amount' => 'decimal:2',
            'balance' => 'decimal:2',
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
