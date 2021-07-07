<?php

use App\Http\Controllers\AlbumController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/albums/create', [AlbumController::class, 'Create'])->middleware('auth');

Route::post('/albums/store', [AlbumController::class, 'store'])->middleware('auth');

Route::get('/albums', [AlbumController::class, 'index'])->middleware('auth');

Route::get('/getalbums', [AlbumController::class, 'getAlbums'])->middleware('auth');