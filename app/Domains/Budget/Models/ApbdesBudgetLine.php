<?php

namespace App\Domains\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApbdesBudgetLine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'fiscal_year_id',
        'account_id',
        'funding_source_id',
        'description',
        'amount',
        'realized_amount',
        'sort_order',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'realized_amount' => 'decimal:2',
        ];
    }

    public function fiscalYear(): BelongsTo
    {
        return $this->belongsTo(ApbdesFiscalYear::class, 'fiscal_year_id');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(ApbdesAccount::class, 'account_id');
    }

    public function fundingSource(): BelongsTo
    {
        return $this->belongsTo(ApbdesFundingSource::class, 'funding_source_id');
    }
}
