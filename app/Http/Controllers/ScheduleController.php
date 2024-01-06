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
            'session' => 'required',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with('error','Cannot Schedule this Course');
        }
        $schedule = Schedule::create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'course_id' => $request->course_id,
            'session' => $request->session,
        ]);

        if(!$schedule)
        {
            return redirect()->back()->with('error','Action Failed');
        }

        return redirect()->route('schedule')->with('success','You have Schedule the Course');
    }

    public function edit(Schedule $schedule)
    {
        $courses = Course::all();
        return view('schedule.schedule-edit',compact('schedule','courses'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validator = Validator::make($request->all(),[
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'course_id' => 'required|exists:courses,id',
            'session' => 'required',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with('error','Cannot Schedule this Course');
        }
        $updated = $schedule->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'course_id' => $request->course_id,
            'session' => $request->session,
        ]);

        if(!$updated)
        {
            return redirect()->back()->with('error','Action Failed');
        }

        return redirect()->route('schedule')->with('success','You have Schedule the Course');
    }

    public function destroy(Schedule $schedule)
    {
        $deleted = $schedule->delete();
        if(!$deleted)
        {
            return redirect()->back()->with('error','Cannot Archive this Schedule');
        }
        return redirect()->route('schedule')->with('success','Schedule Archived');
    }

    public function archives()
    {
        $schedules = Schedule::onlyTrashed()->with('course')->get();
        return view('schedule.schedule-archives',compact('schedules'));
    }

    public function restore($id)
    {
        $schedule = Schedule::onlyTrashed()->findOrFail($id);
        $restored = $schedule->restore();
        if(!$restored)
        {
            return redirect()->back()->with('error','Cannot Restore this Schedule');
        }
        return redirect()->route('schedule')->with('success','Data Restored');
    }

    public function forcedelete($id)
    {
        $schedule = Schedule::onlyTrashed()->findOrFail($id);
        $deleted = $schedule->forceDelete();
        if(!$deleted)
        {
            return redirect()->back()->with('error','Cannot Force Delete this Schedule');
        }
        return redirect()->route('schedule.archives')->with('success','Data Deleted Permanently');
    }
}
