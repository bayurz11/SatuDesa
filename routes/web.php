<?php

use App\Http\Controllers\StorageFileController;
use Illuminate\Support\Facades\Route;

Route::get('/uploads/{path}', [StorageFileController::class, 'show'])
    ->where('path', '.*')
    ->name('uploads.show');

require __DIR__ . '/web/public.php';
require __DIR__ . '/web/citizen.php';
require __DIR__ . '/web/admin.php';
