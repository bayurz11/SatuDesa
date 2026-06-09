<?php

namespace App\Domains\Citizen\Models;

use App\Domains\Citizen\Models\CitizenArrival;
use App\Domains\Citizen\Models\CitizenBirth;
use App\Domains\Citizen\Models\CitizenDeath;
use App\Domains\Household\Models\Household;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Citizen extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'household_id',
        'nik',
        'full_name',
        'gender',
        'birth_place',
        'birth_date',
        'religion',
        'marital_status',
        'family_relationship',
        'occupation',
        'education',
        'citizenship',
        'address',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
        ];
    }

    public function household(): BelongsTo
    {
        return $this->belongsTo(Household::class);
    }

    public function birth(): HasOne
    {
        return $this->hasOne(CitizenBirth::class);
    }

    public function arrivals(): HasMany
    {
        return $this->hasMany(CitizenArrival::class);
    }

    public function death(): HasOne
    {
        return $this->hasOne(CitizenDeath::class);
    }
}
