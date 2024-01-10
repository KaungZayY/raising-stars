<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendingController extends Controller
{
    public function index()
    {
        $pendings = DB::table('schedule_student')->where('status', 'pending')
        ->join('schedules', 'schedule_student.schedule_id', '=', 'schedules.id')
        ->join('users', 'schedule_student.user_id', '=', 'users.id')
        ->join('courses', 'schedules.course_id', '=', 'courses.id')
        ->select('courses.course','schedules.*','users.name','users.email')
        ->get();
        // dd($pendings);
        return view('pending.pending-list',compact('pendings'));
    }
}
