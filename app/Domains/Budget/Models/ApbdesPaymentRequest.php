<?php

namespace App\Domains\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApbdesPaymentRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'fiscal_year_id',
        'budget_line_id',
        'request_number',
        'request_date',
        'payee_name',
        'amount',
        'status',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'request_date' => 'date',
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

    public function realizations(): HasMany
    {
        return $this->hasMany(ApbdesRealization::class, 'payment_request_id');
    }
}
