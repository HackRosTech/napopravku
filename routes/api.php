<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('user/index', [\App\Http\Controllers\User\MainController::class, 'index'])->middleware('auth:sanctum');

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'file'
], function () {
    Route::post('upload', [\App\Http\Controllers\File\MainController::class, 'upload'])->middleware('checksize');
    Route::get('index', [\App\Http\Controllers\File\MainController::class, 'index']);
    Route::patch('rename/{id}', [\App\Http\Controllers\File\MainController::class, 'rename']);
    Route::delete('delete/{id}', [\App\Http\Controllers\File\MainController::class, 'destroy']);
    Route::get('download/{id}', [\App\Http\Controllers\File\MainController::class, 'download']);
    Route::get('size-in-directory/{id}', [\App\Http\Controllers\File\MainController::class, 'sizeFilesInDirectory']);
    Route::get('size-on-disk', [\App\Http\Controllers\File\MainController::class, 'sizeFilesOnDisk']);
});

Route::post('/file/links/{id}', [\App\Http\Controllers\File\FileLinkController::class, 'store'])->middleware('auth:sanctum');
Route::get('/file/links/{id}', [\App\Http\Controllers\File\FileLinkController::class, 'show']);

Route::post('directory/create', [\App\Http\Controllers\Directory\MainController::class, 'create'])->middleware('auth:sanctum');
