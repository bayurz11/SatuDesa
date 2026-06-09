<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class UploadStorage
{
    public static function disk(): string
    {
        return config('filesystems.uploads_disk', 'uploads');
    }

    public static function url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        $normalizedPath = ltrim($path, '/');

        if (Storage::disk(static::disk())->exists($normalizedPath)) {
            return url('/storage/' . $normalizedPath);
        }

        return url('/storage/' . $normalizedPath);
    }
}
