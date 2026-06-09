<?php

namespace App\Domains\Citizen\Models;

use App\Domains\Household\Models\Household;
use App\Domains\Village\Models\Village;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CitizenBirth extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'village_id',
        'citizen_id',
        'household_id',
        'father_nik',
        'father_name',
        'mother_nik',
        'mother_name',
        'birth_time',
        'birth_weight',
        'birth_length',
        'birth_order',
        'birth_type',
        'birth_attendant',
        'birth_certificate_number',
        'reporter_name',
        'reporter_relation',
        'witness_1_name',
        'witness_2_name',
        'notes',
    ];

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
