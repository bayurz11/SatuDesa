<?php

namespace App\Domains\Rt\Models;

use App\Domains\Rw\Models\Rw;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rt extends Model
{
    protected $fillable = [
        'village_id',
        'rw_id',
        'number',
    ];

    public function rw(): BelongsTo
    {
        return $this->belongsTo(Rw::class);
    }
}
