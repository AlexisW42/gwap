<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::view('/upload-image', 'upload-image');
Route::get('/game', [ImageController::class, 'getImages']);
Route::post('/upload-image', [ImageController::class, 'saveImage']);
