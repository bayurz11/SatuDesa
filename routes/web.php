<?php

use App\Http\Controllers\StorageFileController;
use Illuminate\Support\Facades\Route;

Route::get('/storage/{path}', [StorageFileController::class, 'show'])
    ->where('path', '.*')
    ->name('storage.uploads.show');

require __DIR__ . '/web/public.php';
require __DIR__ . '/web/citizen.php';
require __DIR__ . '/web/admin.php';
