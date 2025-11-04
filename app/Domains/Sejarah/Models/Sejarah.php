<?php

namespace App\Domains\Sejarah\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sejarah extends Model
{
    use HasFactory;
    protected $table = 'sejarah';

    protected $casts = [
        'tanggal'   => 'date',
        'is_active' => 'boolean',
    ];

    protected $fillable = [
        'isi',
        'gambar',
        'tanggal',
        'is_active',
    ];
}
