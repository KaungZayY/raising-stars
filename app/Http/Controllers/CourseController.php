<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::autosort()->get();
        return view('course.course-list',['courses'=>$courses]);
    }
}
