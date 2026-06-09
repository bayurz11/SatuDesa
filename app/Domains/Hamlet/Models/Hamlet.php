<?php

namespace App\Domains\Hamlet\Models;

use App\Domains\Rw\Models\Rw;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hamlet extends Model
{
    protected $fillable = [
        'village_id',
        'name',
        'code',
    ];

    public function rws(): HasMany
    {
        return $this->hasMany(Rw::class);
    }
}
