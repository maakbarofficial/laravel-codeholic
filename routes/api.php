<?php

use App\Http\Controllers\API\v1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/hello', function () {
    return 'Hello from Laravel APIs';
});

Route::prefix('v1')->group(function () {
    Route::apiResource('posts', PostController::class);
});

require __DIR__.'/auth.php';