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

        if (str_starts_with($normalizedPath, 'http://') || str_starts_with($normalizedPath, 'https://')) {
            return $normalizedPath;
        }

        return Storage::disk(static::disk())->url($normalizedPath);
    }
}
