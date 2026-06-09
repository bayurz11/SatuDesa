<?php

namespace App\Domains\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApbdesRealization extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'fiscal_year_id',
        'budget_line_id',
        'payment_request_id',
        'transaction_date',
        'reference_number',
        'payment_method',
        'amount',
        'status',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    public function fiscalYear(): BelongsTo
    {
        return $this->belongsTo(ApbdesFiscalYear::class, 'fiscal_year_id');
    }

    public function budgetLine(): BelongsTo
    {
        return $this->belongsTo(ApbdesBudgetLine::class, 'budget_line_id');
    }

    public function paymentRequest(): BelongsTo
    {
        return $this->belongsTo(ApbdesPaymentRequest::class, 'payment_request_id');
    }

    public function cashBookEntries(): HasMany
    {
        return $this->hasMany(ApbdesCashBookEntry::class, 'realization_id');
    }

    public function bankBookEntries(): HasMany
    {
        return $this->hasMany(ApbdesBankBookEntry::class, 'realization_id');
    }

    public function taxBookEntries(): HasMany
    {
        return $this->hasMany(ApbdesTaxBookEntry::class, 'realization_id');
    }
}
