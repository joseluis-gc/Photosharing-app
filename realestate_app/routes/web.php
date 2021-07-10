<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\GalleryController;
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


//albums
Route::get('/albums', [AlbumController::class, 'index'])->middleware('auth');

Route::get('/getalbums', [AlbumController::class, 'getAlbums'])->middleware('auth');

Route::get('/albums/create', [AlbumController::class, 'Create'])->name('album.create')->middleware('auth');

Route::post('/albums/store', [AlbumController::class, 'store'])->middleware('auth');

Route::put('/albums/{id}/edit', [AlbumController::class, 'Update']);

Route::delete('/albums/{id}/delete', [AlbumController::class, 'destroy'])->middleware('auth');



//gallery and gallery uploads
Route::get('/upload/images/{id}', [GalleryController::class, 'create'])->middleware('auth');

Route::get('/getimages', [GalleryController::class, 'images'])->middleware('auth');

Route::post('uploadImage', [GalleryController::class, 'upload'])->middleware('auth');
