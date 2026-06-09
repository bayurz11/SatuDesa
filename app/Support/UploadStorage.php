<?php

namespace App\Support;

class UploadStorage
{
    public static function disk(): string
    {
        return config('filesystems.uploads_disk', 'uploads');
    }
}
