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

    // ===== Level konstanta =====
    public const LEVEL_PIMPINAN    = 'pimpinan';
    public const LEVEL_STRUKTURAL  = 'struktural';
    public const LEVEL_KEWILAYAHAN = 'kewilayahan';

    public static function levelOptions(): array
    {
        return [
            self::LEVEL_PIMPINAN    => 'Pimpinan',
            self::LEVEL_STRUKTURAL  => 'Struktural',
            self::LEVEL_KEWILAYAHAN => 'Kewilayahan (Kepala Dusun)',
        ];
    }

    // ===== Default ordering (hierarki → jabatan → nama) =====
    protected static function booted(): void
    {
        static::addGlobalScope('ordered', function (Builder $q) {
            $q->orderByRaw("FIELD(level, 'pimpinan','struktural','kewilayahan')")
                ->orderBy('jabatan')
                ->orderBy('nama');
        });
    }

    // ===== Accessors =====

    /**
     * URL foto yang tahan banting untuk berbagai pola penyimpanan:
     * - Full URL (http/https)
     * - File di public/… (contoh: public/struktur/xxx.jpg)
     * - File di storage/… (pakai disk public dengan symlink)
     * - Path relatif (contoh: struktur/xxx.jpg)
     */


    public function getFotoUrlAttribute(): string
    {
        $rel = ltrim((string) $this->foto, '/'); // "storage/struktur/xxx.jpg"
        if ($rel !== '') {
            // hasil akhir: .../public/storage/struktur/xxx.jpg
            return asset('public/' . $rel);
        }
        // fallback default
        return asset('img/avatars/default-person.png');

        $fallback = asset('img/avatars/default-person.png'); // sediakan file ini di public/img/avatars/

        if (!$this->foto) {
            return $fallback;
        }

        $path = ltrim($this->foto, '/');

        // 1) Sudah URL penuh
        if (preg_match('~^https?://~i', $path)) {
            return $path;
        }

        // 2) Sudah di dalam folder public (hostinger sering pakai pola ini)
        //    contoh tersimpan "public/struktur/xxx.jpg" → akses dengan asset($path)
        if (str_starts_with($path, 'public/')) {
            $publicPath = public_path($path);
            return file_exists($publicPath) ? asset($path) : $fallback;
        }

        // 3) Tersimpan sebagai "storage/struktur/xxx.jpg" → akses asset('storage/…')
        if (str_starts_with($path, 'storage/')) {
            $publicPath = public_path($path);
            return file_exists($publicPath) ? asset($path) : $fallback;
        }

        // 4) Cek di disk 'public' (storage/app/public/…)
        if (Storage::disk('public')->exists($path)) {
            // Ini akan menjadi /storage/struktur/xxx.jpg jika symlink ada
            return asset('storage/' . $path);
        }

        // 5) Terakhir, coba langsung di public/… (untuk yang disalin manual ke public/struktur/…)
        $maybePublic = 'public/' . $path; // contoh: public/struktur/xxx.jpg
        if (file_exists(public_path($maybePublic))) {
            return asset($maybePublic);
        }

        return $fallback;
    }

    /**
     * Label level siap tampil.
     */
    public function getLevelLabelAttribute(): string
    {
        return self::levelOptions()[$this->level] ?? ucfirst((string) $this->level);
    }

    /**
     * Warna badge Tailwind berdasarkan level.
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

    // ===== Scopes =====
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
        if (!$term) return $q;

        return $q->where(function (Builder $w) use ($term) {
            $w->where('jabatan', 'like', "%{$term}%")
                ->orWhere('nama', 'like', "%{$term}%");
        });
    }
}
