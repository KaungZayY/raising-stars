<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentViewController extends Controller
{
    public function formRequest()
    {
        $user_id = Auth()->user()->id;
        $courses = DB::table('schedule_student')->where('user_id', $user_id)
        ->join('schedules', 'schedule_student.schedule_id', '=', 'schedules.id')
        ->join('courses', 'schedules.course_id', '=', 'courses.id')
        ->select('courses.course','schedules.start_date',
        'schedules.end_date','schedules.session','schedule_student.status',
        'schedule_student.created_at','schedule_student.updated_at')
        ->get();
        // dd($pendings);

        return view('student-view.form-request',compact('courses'));
    }
}
