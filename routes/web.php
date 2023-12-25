<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DiscussionReportController;
use App\Http\Controllers\LecturerController;
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
    Route::post('/comment-update{comment}',[CommentController::class,'update'])->name('comment.update');
});

Route::middleware('admin')->group(function(){
    Route::get('/subject',[SubjectController::class,'index'])->name('subject');
    Route::get('/subject-create',[SubjectController::class,'create'])->name('subject.create');
    Route::post('/subject-save',[SubjectController::class,'store'])->name('subject.store');
    Route::get('/subject-edit{subject}', [SubjectController::class, 'edit'])->name('subject.edit');
    Route::post('/subject-edit{subject}', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('/subject-delete{subject}', [SubjectController::class, 'destroy'])->name('subject.delete');
    Route::get('/subject-archives',[SubjectController::class,'archives'])->name('subject.archives');
    Route::patch('/subject-restore/{subject}', [SubjectController::class, 'restore'])->name('subject.restore');
    Route::delete('/subject-force-delete{subject}', [SubjectController::class, 'forcedelete'])->name('subject.forcedelete');

    //Report
    Route::get('/discussion-report',[DiscussionReportController::class,'index'])->name('discussion.report');


    //Category
    Route::get('/category',[CategoryController::class,'index'])->name('category');
    Route::get('/category-create',[CategoryController::class,'create'])->name('category.create');
    Route::post('/category-save',[CategoryController::class,'store'])->name('category.store');
    Route::get('/category-edit{category}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('/category-edit{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category-delete{category}', [CategoryController::class, 'destroy'])->name('category.delete');
    Route::get('/category-archives',[CategoryController::class,'archives'])->name('category.archives');
    Route::patch('/category-restore/{category}', [CategoryController::class, 'restore'])->name('category.restore');
    Route::delete('/category-force-delete{category}', [CategoryController::class, 'forcedelete'])->name('category.forcedelete');
    
    //Lecturer
    Route::get('/lecturer',[LecturerController::class,'index'])->name('lecturer');
    Route::get('/lecturer-create',[LecturerController::class,'create'])->name('lecturer.create');
    Route::post('/lecturer-save',[LecturerController::class,'store'])->name('lecturer.store');
    Route::get('/lecturer-edit{user}', [LecturerController::class, 'edit'])->name('lecturer.edit');
    Route::post('/lecturer-edit{user}', [LecturerController::class, 'update'])->name('lecturer.update');
    Route::delete('/lecturer-delete{user}', [LecturerController::class, 'destroy'])->name('lecturer.delete');
    Route::get('/lecturer-archives',[LecturerController::class,'archives'])->name('lecturer.archives');
    Route::patch('/lecturer-restore/{user}', [LecturerController::class, 'restore'])->name('lecturer.restore');
    Route::delete('/lecturer-force-delete{user}', [LecturerController::class, 'forcedelete'])->name('lecturer.forcedelete');
});

require __DIR__.'/auth.php';
