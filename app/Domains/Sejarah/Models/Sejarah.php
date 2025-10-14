<?php

namespace App\Domains\Sejarah\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sejarah extends Model
{
    use HasFactory;
    protected $table = 'sejarah'; // sesuaikan dengan nama tabel di database

    protected $fillable = [
        'isi',
        'gambar',
        'tanggal',
        'is_active',
    ];
}
