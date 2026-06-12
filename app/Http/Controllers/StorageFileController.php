<?php

namespace App\Http\Controllers;

use App\Support\UploadStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StorageFileController extends Controller
{
    public function show(Request $request, string $path): Response|StreamedResponse|BinaryFileResponse
    {
        $normalizedPath = ltrim($path, '/');

        if (
            $normalizedPath === '' ||
            str_contains($normalizedPath, '..') ||
            ! $this->isAllowedUploadPath($normalizedPath) ||
            ! $this->hasAllowedExtension($normalizedPath)
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

    protected function hasAllowedExtension(string $path): bool
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true);
    }
}
