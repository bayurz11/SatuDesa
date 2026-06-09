<?php

namespace App\Domains\Citizen\Models;

use App\Domains\Household\Models\Household;
use App\Domains\Village\Models\Village;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CitizenArrival extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'village_id',
        'citizen_id',
        'household_id',
        'arrival_date',
        'origin_address',
        'origin_region',
        'origin_no_kk',
        'moved_member_count',
        'moving_certificate_number',
        'arrival_reason',
        'reporter_name',
        'arrival_classification',
        'reporter_relation',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'arrival_date' => 'date',
        ];
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function citizen(): BelongsTo
    {
        return $this->belongsTo(Citizen::class);
    }

    public function household(): BelongsTo
    {
        return $this->belongsTo(Household::class);
    }
}
