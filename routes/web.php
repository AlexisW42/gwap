<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\JoinToGameController;
use \App\Http\Controllers\SendWordController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin_dashboard', 'App\Http\Controllers\Admin\DashboardController@index')->name('admin_dashboard')->middleware('role:admin');
Route::get('/player_dashboard', 'App\Http\Controllers\Player\DashboardController@index')->name('player_dashboard')->middleware('role:player');

Route::get('/dashboard', function () {
    switch($role = Auth::user()->role){
        case 'admin':
            return to_route('admin_dashboard');
            break;
        case 'player':
            return to_route('player_dashboard');
            break;
        default:
        return view('dashboard');
    }
    
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/game', [ImageController::class, 'getImages']);
    Route::post('/upload-image', [ImageController::class, 'saveImage']);
    Route::get('/play-game', JoinToGameController::class);
    Route::post('/send-word', SendWordController::class);
});

require __DIR__.'/auth.php';

Route::get('/upload-image', function () {
    abort_if(Auth::user()->role != 'admin', 403);
    return view('upload-image');
});
