<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::autosort()->with('course')->get();
        return view('schedule.schedule-list',compact('schedules'));
    }
}
