<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
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
    Route::get('/post-detail{post}', [PostController::class, 'detail'])->name('post.detail');

    //like
    Route::post('/like',[LikeController::class,'postLiked'])->name('post.like');
    Route::delete('/like',[LikeController::class,'postUnLiked'])->name('post.unlike');

    //Comment
    Route::post('/comment',[CommentController::class,'postCommented'])->name('post.comment');
    Route::delete('/comment-delete{comment}', [CommentController::class, 'destroy'])->name('comment.delete');
});

Route::middleware('admin')->group(function(){
    Route::get('/subject',[SubjectController::class,'index'])->name('subject');
    Route::get('/subject-create',[SubjectController::class,'create'])->name('subject.create');
    Route::post('/subject-save',[SubjectController::class,'store'])->name('subject.store');
    Route::get('/subject-edit{subject}', [SubjectController::class, 'edit'])->name('subject.edit');
    Route::post('/subject-edit{subject}', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('/subject-delete{subject}', [SubjectController::class, 'destroy'])->name('subject.delete');
    
});

require __DIR__.'/auth.php';
