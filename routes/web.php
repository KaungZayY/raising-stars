<?php

use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //post
    Route::get('/home',[PostController::class, 'index'])->name('home');
    Route::get('/post', [PostController::class, 'create'])->name('post.create');
    Route::post('/post',[PostController::class,'store'])->name('post.store');
    Route::get('/post-edit{post}', [PostController::class, 'edit'])->name('post.edit');
    Route::post('/post-edit{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post-delete{post}', [PostController::class, 'destroy'])->name('post.delete');

    //like
    Route::post('/like',[LikeController::class,'postLiked'])->name('post.like');
    Route::delete('/like',[LikeController::class,'postUnLiked'])->name('post.unlike');
});

require __DIR__.'/auth.php';
