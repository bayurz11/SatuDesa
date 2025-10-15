<?php

namespace App\Domains\Visimisi\Models;

use Illuminate\Database\Eloquent\Model;

class Visimisi extends Model
{
    // izinkan kolom berikut untuk mass assignment
    protected $fillable = [
        'kategori',
        'isi',
        'gambar',
        'is_active',
    ];

    public function getIsiArrayAttribute()
    {
        return preg_split('/\r\n|\r|\n/', trim($this->isi));
    }
}
