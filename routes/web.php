<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Crud\PostController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/posts/{tagId?}', [PostController::class, 'show']);
Route::get('/post', [PostController::class, 'create']);
Route::get('/post/{slug}', [PostController::class, 'edit']);
Route::post('/store', [PostController::class, 'store']);
Route::delete('/delete/{slug}', [PostController::class, 'delete']);

require __DIR__.'/auth.php';
