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
            return route('uploads.show', ['path' => $normalizedPath]);
        }

        if (Storage::disk('public')->exists($normalizedPath)) {
            return Storage::disk('public')->url($normalizedPath);
        }

        return route('uploads.show', ['path' => $normalizedPath]);
    }
}
