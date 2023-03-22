<?php

use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload-image', function (){

    return view('upload-image');
});

Route::post('/upload-image', [ImageController::class, 'saveImage']);
