<?php

namespace App\Http\Controllers;

use App\Support\UploadStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class StorageFileController extends Controller
{
    public function show(Request $request, string $path): Response
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

        if ($disk->exists($normalizedPath)) {
            return $disk->response($normalizedPath, null, [
                'Cache-Control' => 'public, max-age=86400',
            ]);
        }

        $legacyPath = storage_path($normalizedPath);

        if (is_file($legacyPath)) {
            return response()->file($legacyPath, [
                'Cache-Control' => 'public, max-age=86400',
            ]);
        }

        abort(404);
    }

    protected function isAllowedUploadPath(string $path): bool
    {
        foreach ([
            'avatars/',
            'posts/',
            'potentials/',
            'galleries/',
            'village-histories/',
            'village-organizations/',
        ] as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return true;
            }
        }

        return false;
    }
}
