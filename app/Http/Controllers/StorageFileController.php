<?php

namespace App\Http\Controllers;

use App\Support\UploadStorage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class StorageFileController extends Controller
{
    public function show(string $path): Response
    {
        $normalizedPath = ltrim($path, '/');

        if (
            $normalizedPath === '' ||
            str_contains($normalizedPath, '..') ||
            ! $this->isAllowedUploadPath($normalizedPath)
        ) {
            abort(404);
        }

        $disk = Storage::disk(UploadStorage::disk());

        if (! $disk->exists($normalizedPath)) {
            abort(404);
        }

        return $disk->response($normalizedPath);
    }

    protected function isAllowedUploadPath(string $path): bool
    {
        foreach (['avatars/', 'posts/', 'potentials/'] as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return true;
            }
        }

        return false;
    }
}
