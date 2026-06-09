<?php

namespace App\Domains\Rw\Models;

use App\Domains\Hamlet\Models\Hamlet;
use App\Domains\Rt\Models\Rt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rw extends Model
{
    protected $fillable = [
        'village_id',
        'hamlet_id',
        'number',
    ];

    public function hamlet(): BelongsTo
    {
        return $this->belongsTo(Hamlet::class);
    }

    public function rts(): HasMany
    {
        return $this->hasMany(Rt::class);
    }
}
