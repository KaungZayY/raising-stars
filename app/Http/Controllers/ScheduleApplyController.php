<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleApplyController extends Controller
{
    public function index(Schedule $schedule)
    {
        return view('apply.schedule-apply',compact('schedule'));
    }

    public function store(Request $request, Schedule $schedule)
    {
        dd($request);
    }
}
