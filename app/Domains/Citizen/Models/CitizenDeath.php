<?php

namespace App\Domains\Citizen\Models;

use App\Domains\Village\Models\Village;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CitizenDeath extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'village_id',
        'citizen_id',
        'death_date',
        'death_time',
        'death_place',
        'cause_of_death',
        'certifier',
        'death_certificate_number',
        'reporter_name',
        'reporter_relation',
        'witness_1_name',
        'witness_2_name',
        'burial_place',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'death_date' => 'date',
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
}
