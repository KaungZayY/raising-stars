<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DiscussionReportController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LecturerController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PendingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ScheduleApplyController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentViewController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //post
    Route::get('/',[PostController::class, 'index'])->name('home');
    Route::get('/post', [PostController::class, 'create'])->name('post.create');
    Route::post('/post',[PostController::class,'store'])->name('post.store');
    Route::get('/post/edit{post}', [PostController::class, 'edit'])->name('post.edit');
    Route::post('/post/edit{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/post/delete{post}', [PostController::class, 'destroy'])->name('post.delete');
    Route::get('/post/detail{post}', [PostController::class, 'detail'])->name('post.detail');

    //like
    Route::post('/like',[LikeController::class,'postLiked'])->name('post.like');
    Route::delete('/like',[LikeController::class,'postUnLiked'])->name('post.unlike');

    //Comment
    Route::post('/comment',[CommentController::class,'postCommented'])->name('post.comment');
    Route::delete('/comment/delete{comment}', [CommentController::class, 'destroy'])->name('comment.delete');
    Route::post('/comment/update{comment}',[CommentController::class,'update'])->name('comment.update');

    //Available Courses
    Route::get('/courses',[CourseController::class,'availableCourses'])->name('courses');
    Route::get('/courses{course}/sessions',[CourseController::class,'courseSession'])->name('course.session');
    Route::get('/courses{course}/{session}/schedules',[CourseController::class,'courseBySession'])->name('courses.bysession');

    //View My Groups
    Route::get('/my-groups',[GroupController::class,'myGroups'])->name('groups');
});

Route::middleware('student')->group(function(){
    Route::get('/schedule{schedule}/apply',[ScheduleApplyController::class,'index'])->name('schedule.apply');
    Route::post('/schedule{schedule}/apply',[ScheduleApplyController::class,'store']);

    //Pendings
    Route::get('/request',[StudentViewController::class,'formRequest'])->name('request');
    Route::get('/request/search',[StudentViewController::class,'search'])->name('request.search');
    
    //View Courses
    Route::get('/my-courses',[StudentViewController::class,'myCourses'])->name('myCourses');
    Route::get('/course{id}/detail',[StudentViewController::class,'courseDetail'])->name('course.detail');
});

Route::middleware('admin')->group(function(){
    //Subject
    Route::get('/subject',[SubjectController::class,'index'])->name('subject');
    Route::get('/subject/create',[SubjectController::class,'create'])->name('subject.create');
    Route::post('/subject/save',[SubjectController::class,'store'])->name('subject.store');
    Route::get('/subject/edit{subject}', [SubjectController::class, 'edit'])->name('subject.edit');
    Route::post('/subject/edit{subject}', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('/subject/delete{subject}', [SubjectController::class, 'destroy'])->name('subject.delete');
    Route::get('/subject/archives',[SubjectController::class,'archives'])->name('subject.archives');
    Route::patch('/subject/restore/{subject}', [SubjectController::class, 'restore'])->name('subject.restore');
    Route::delete('/subject/force-delete{subject}', [SubjectController::class, 'forcedelete'])->name('subject.forcedelete');
    //Subject Search
    Route::get('/subject/search',[SubjectController::class,'search'])->name('subject.search');

    //Report
    Route::get('/discussion/report',[DiscussionReportController::class,'index'])->name('discussion.report');


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
    Route::get('/lecturer/create',[LecturerController::class,'create'])->name('lecturer.create');
    Route::post('/lecturer/save',[LecturerController::class,'store'])->name('lecturer.store');
    Route::get('/lecturer/edit{user}', [LecturerController::class, 'edit'])->name('lecturer.edit');
    Route::post('/lecturer/edit{user}', [LecturerController::class, 'update'])->name('lecturer.update');
    Route::delete('/lecturer/delete{user}', [LecturerController::class, 'destroy'])->name('lecturer.delete');
    Route::get('/lecturer/archives',[LecturerController::class,'archives'])->name('lecturer.archives');
    Route::patch('/lecturer/restore/{user}', [LecturerController::class, 'restore'])->name('lecturer.restore');
    Route::delete('/lecturer/force-delete{user}', [LecturerController::class, 'forcedelete'])->name('lecturer.forcedelete');
    Route::get('/lecturer/export',[LecturerController::class,'export'])->name('lecturer.export');
    //Lecturer Search
    Route::get('/lecturer/search',[LecturerController::class,'search'])->name('lecturer.search');

    //Moderator
    Route::get('/moderator',[ModeratorController::class,'index'])->name('moderator');
    Route::get('/moderator/create',[ModeratorController::class,'create'])->name('moderator.create');
    Route::post('/moderator/save',[ModeratorController::class,'store'])->name('moderator.store');
    Route::get('/moderator/edit{user}', [ModeratorController::class, 'edit'])->name('moderator.edit');
    Route::post('/moderator/edit{user}', [ModeratorController::class, 'update'])->name('moderator.update');
    Route::delete('/moderator/delete{user}', [ModeratorController::class, 'destroy'])->name('moderator.delete');
    Route::get('/moderator/archives',[ModeratorController::class,'archives'])->name('moderator.archives');
    Route::patch('/moderator/restore/{user}', [ModeratorController::class, 'restore'])->name('moderator.restore');
    Route::delete('/moderator/force-delete{user}', [ModeratorController::class, 'forcedelete'])->name('moderator.forcedelete');
    Route::get('/moderator/export',[ModeratorController::class,'export'])->name('moderator.export');
    Route::get('/moderator/{id}/role',[ModeratorController::class,'role'])->name('moderator.role');
    Route::post('/moderator/{id}/role',[ModeratorController::class,'roleUpdate']);
    //Moderator Search
    Route::get('/moderator/search',[ModeratorController::class,'search'])->name('moderator.search');

    //Student
    Route::get('/student',[StudentController::class,'index'])->name('student');
    Route::get('/student/edit{user}', [StudentController::class, 'edit'])->name('student.edit');
    Route::post('/student/edit{user}', [StudentController::class, 'update'])->name('student.update');
    Route::delete('/student/delete{user}', [StudentController::class, 'destroy'])->name('student.delete');
    Route::get('/student/archives',[StudentController::class,'archives'])->name('student.archives');
    Route::patch('/student/restore/{user}', [StudentController::class, 'restore'])->name('student.restore');
    Route::delete('/student/force-delete{user}', [StudentController::class, 'forcedelete'])->name('student.forcedelete');
    Route::get('/student/{id}/info',[StudentController::class,'info'])->name('student.info');
    // Route::get('/student/export',[StudentController::class,'export'])->name('student.export');
    //Lecturer Search
    Route::get('/student/search',[StudentController::class,'search'])->name('student.search');

    //Room
    Route::get('/room',[RoomController::class,'index'])->name('room');
    Route::get('/room/create',[RoomController::class,'create'])->name('room.create');
    Route::post('/room/save',[RoomController::class,'store'])->name('room.store');
    Route::get('/room/edit{room}', [RoomController::class, 'edit'])->name('room.edit');
    Route::post('/room/edit{room}', [RoomController::class, 'update'])->name('room.update');
    Route::delete('/room/delete{room}', [RoomController::class, 'destroy'])->name('room.delete');
    Route::get('/room/archives',[RoomController::class,'archives'])->name('room.archives');
    Route::patch('/room/restore/{room}', [RoomController::class, 'restore'])->name('room.restore');
    Route::delete('/room/force-delete{room}', [RoomController::class, 'forcedelete'])->name('room.forcedelete');
    //Room Search
    Route::get('/room/search',[RoomController::class,'search'])->name('room.search');

    //Module
    Route::get('/module',[ModuleController::class,'index'])->name('module');
    Route::get('/module/create/{course_id?}',[ModuleController::class,'create'])->name('module.create');
    Route::post('/module/save',[ModuleController::class,'store'])->name('module.store');
    Route::get('/module/edit{module}', [ModuleController::class, 'edit'])->name('module.edit');
    Route::post('/module/edit{module}', [ModuleController::class, 'update'])->name('module.update');
    Route::delete('/module/delete{module}', [ModuleController::class, 'destroy'])->name('module.delete');
    Route::get('/module/archives',[ModuleController::class,'archives'])->name('module.archives');
    Route::patch('/module/restore/{module}', [ModuleController::class, 'restore'])->name('module.restore');
    Route::delete('/module/force-delete{module}', [ModuleController::class, 'forcedelete'])->name('module.forcedelete');
    //Room Search
    Route::get('/module/search',[ModuleController::class,'search'])->name('module.search');

    //Course
    Route::get('/course',[CourseController::class,'index'])->name('course');
    Route::get('/course/create',[CourseController::class,'create'])->name('course.create');
    Route::post('/course/save',[CourseController::class,'store'])->name('course.store');
    Route::get('/course/edit{course}', [CourseController::class, 'edit'])->name('course.edit');
    Route::post('/course/edit{course}', [CourseController::class, 'update'])->name('course.update');
    Route::delete('/course/delete{course}', [CourseController::class, 'destroy'])->name('course.delete');
    Route::get('/course/archives',[CourseController::class,'archives'])->name('course.archives');
    Route::patch('/course/restore/{course}', [CourseController::class, 'restore'])->name('course.restore');
    Route::delete('/course/force-delete{course}', [CourseController::class, 'forcedelete'])->name('course.forcedelete');
    //Course Search
    Route::get('/course/search',[CourseController::class,'search'])->name('course.search');

    //Assign Module to Course
    Route::get('/course{course}/modules', [CourseController::class, 'module'])->name('course.module');
    Route::get('/course{course}/modules/add', [CourseController::class, 'moduleAdd'])->name('course.moduleadd');
    Route::delete('/course{course}/modules/remove',[CourseController::class,'moduleRemove'])->name('course.moduleremove');
    Route::post('course/module/assign',[CourseController::class,'assign'])->name('course.moduleassign');
    Route::delete('/course/module/unassign',[CourseController::class,'unassign'])->name('course.moduleunassign');

    //Schedule
    Route::get('/schedule',[ScheduleController::class,'index'])->name('schedule');
    Route::get('/schedule-create',[ScheduleController::class,'create'])->name('schedule.create');
    Route::post('/schedule-save',[ScheduleController::class,'store'])->name('schedule.store');
    Route::get('/schedule-edit{schedule}', [ScheduleController::class, 'edit'])->name('schedule.edit');
    Route::post('/schedule-edit{schedule}', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule-delete{schedule}', [ScheduleController::class, 'destroy'])->name('schedule.delete');
    Route::get('/schedule-archives',[ScheduleController::class,'archives'])->name('schedule.archives');
    Route::patch('/schedule-restore/{schedule}', [ScheduleController::class, 'restore'])->name('schedule.restore');
    Route::delete('/schedule-force-delete{schedule}', [ScheduleController::class, 'forcedelete'])->name('schedule.forcedelete');

    //Pendings
    Route::get('/pendings',[PendingController::class,'index'])->name('pending');
    Route::get('/pendings/search',[PendingController::class,'search'])->name('pending.search');
    Route::get('/pending/{id}/detail',[PendingController::class,'detail'])->name('pending.detail');
    Route::post('/pending/{id}/approve',[PendingController::class,'approve'])->name('pending.approve');
    Route::post('/pending/{id}/reject',[PendingController::class,'reject'])->name('pending.reject');

});

Route::middleware('moderator')->group(function(){
    
    //Group
    Route::get('/groups',[GroupController::class,'index'])->name('group');
    Route::get('/group/create',[GroupController::class,'create'])->name('group.create');
    Route::post('/group/save',[GroupController::class,'store'])->name('group.store');
    Route::get('/group/edit{group}', [GroupController::class, 'edit'])->name('group.edit');
    Route::post('/group/edit{group}', [GroupController::class, 'update'])->name('group.update');
    Route::delete('/group/delete{group}', [GroupController::class, 'destroy'])->name('group.delete');
    Route::get('/group/archives',[GroupController::class,'archives'])->name('group.archives');
    Route::patch('/group/restore/{group}', [GroupController::class, 'restore'])->name('group.restore');
    Route::delete('/group/force-delete{group}', [GroupController::class, 'forcedelete'])->name('group.forcedelete');
    //Group Members
    Route::get('/group/{group}/members',[GroupController::class,'members'])->name('group.members');
    Route::get('/group/{group}/member/add',[GroupController::class,'addMember'])->name('group.addMember');
    Route::post('/group/member/add',[GroupController::class,'ajaxAdd'])->name('group.ajaxAdd');
    Route::delete('/group/member/add',[GroupController::class,'ajaxRemove'])->name('group.ajaxRemove');
    Route::delete('/group/{groupId}/member/{userId}/remove', [GroupController::class, 'removeMember'])->name('group.removeMember');
    //Group Search
    Route::get('/group/search',[GroupController::class,'search'])->name('group.search');
    Route::get('/group/{group}/members/search',[GroupController::class,'searchMember'])->name('group.searchMember');
    Route::get('/group/{group}/member/add/search',[GroupController::class,'searchNonMember'])->name('group.searchNonMember');
});

require __DIR__.'/auth.php';
