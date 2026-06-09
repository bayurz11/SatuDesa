<?php

namespace App\Domains\Household\Models;

use App\Domains\Citizen\Models\Citizen;
use App\Domains\Hamlet\Models\Hamlet;
use App\Domains\Rt\Models\Rt;
use App\Domains\Rw\Models\Rw;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Household extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'village_id',
        'no_kk',
        'head_citizen_id',
        'hamlet_id',
        'rw_id',
        'rt_id',
        'address',
    ];

    public function citizens(): HasMany
    {
        return $this->hasMany(Citizen::class);
    }

    public function headCitizen(): BelongsTo
    {
        return $this->belongsTo(Citizen::class, 'head_citizen_id');
    }

    public function hamlet(): BelongsTo
    {
        return $this->belongsTo(Hamlet::class);
    }

    public function rw(): BelongsTo
    {
        return $this->belongsTo(Rw::class);
    }

    public function rt(): BelongsTo
    {
        return $this->belongsTo(Rt::class);
    }
}
