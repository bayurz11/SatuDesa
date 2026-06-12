<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;

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

        if (Route::has('storage.uploads.show')) {
            return route('storage.uploads.show', ['path' => $normalizedPath]);
        }

        return url('/storage/' . $normalizedPath);
    }
}
