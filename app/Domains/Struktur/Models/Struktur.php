<?php

namespace App\Domains\Struktur\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class Struktur extends Model
{
    use HasFactory;

    protected $table = 'struktur_organisasi';

    protected $fillable = [
        'jabatan',
        'nama',
        'level',
        'foto',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Konstanta level (sesuai legenda)
    public const LEVEL_PIMPINAN    = 'pimpinan';
    public const LEVEL_STRUKTURAL  = 'struktural';
    public const LEVEL_KEWILAYAHAN = 'kewilayahan';

    /**
     * Opsi level untuk select (value => label)
     */
    public static function levelOptions(): array
    {
        return [
            self::LEVEL_PIMPINAN    => 'Pimpinan',
            self::LEVEL_STRUKTURAL  => 'Struktural',
            self::LEVEL_KEWILAYAHAN => 'Kewilayahan (RT/RW)',
        ];
    }

    /**
     * Global scope: urutkan sesuai hirarki + jabatan
     */
    protected static function booted(): void
    {
        static::addGlobalScope('ordered', function (Builder $q) {
            $q->orderByRaw("FIELD(level, 'pimpinan','struktural','kewilayahan')")
                ->orderBy('jabatan');
        });
    }

    /**
     * Accessor: URL foto siap pakai (fallback ke aset default)
     */
    public function getFotoUrlAttribute(): string
    {
        if (empty($this->foto)) {
            return asset('img/avatars/default-person.png'); // sediakan file ini
        }

        // Jika sudah URL penuh, kembalikan apa adanya
        if (preg_match('~^https?://~i', $this->foto)) {
            return $this->foto;
        }

        // Jika path relatif storage
        return Storage::url($this->foto);
    }

    /**
     * Accessor: label level siap tampil
     */
    public function getLevelLabelAttribute(): string
    {
        return self::levelOptions()[$this->level] ?? ucfirst((string) $this->level);
    }

    /**
     * Accessor: warna badge Tailwind sesuai legenda
     * (pimpinan=green-600, struktural=emerald-400, kewilayahan=lime-400)
     */
    public function getBadgeColorAttribute(): string
    {
        return match ($this->level) {
            self::LEVEL_PIMPINAN    => 'bg-green-600',
            self::LEVEL_STRUKTURAL  => 'bg-emerald-400',
            self::LEVEL_KEWILAYAHAN => 'bg-lime-400',
            default                 => 'bg-gray-300',
        };
    }

    /* ===========================
     * Query Scopes
     * ===========================
     */

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    public function scopeLevel(Builder $q, string $level): Builder
    {
        return $q->where('level', $level);
    }

    public function scopeSearch(Builder $q, ?string $term): Builder
    {
        if (!$term) {
            return $q;
        }

        return $q->where(function (Builder $w) use ($term) {
            $w->where('jabatan', 'like', "%{$term}%")
                ->orWhere('nama', 'like', "%{$term}%");
        });
    }
}
