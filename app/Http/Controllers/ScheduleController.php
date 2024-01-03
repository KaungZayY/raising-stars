<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::autosort()->with('course')->get();
        return view('schedule.schedule-list',compact('schedules'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('schedule.schedule-create',compact('courses'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(),[
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'course_id' => 'required|exists:courses,id',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with('error','Cannot Schedule this Course');
        }
        $schedule = Schedule::create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'course_id' => $request->course_id,
        ]);

        if(!$schedule)
        {
            return redirect()->back()->with('error','Action Failed');
        }

        return redirect()->route('schedule')->with('success','You have Schedule the Course');
    }
}
