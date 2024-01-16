<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\StudentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ScheduleApplyController extends Controller
{
    public function index(Schedule $schedule)
    {
        $studentInfo = StudentInfo::where('user_id', Auth::user()->id)->first();
        return view('apply.schedule-apply', compact('schedule', 'studentInfo'));
    }

    public function store(Request $request, Schedule $schedule)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            //Student Info Table
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|min:8|max:11',
            'parent_email' => 'required|string|email|lowercase|max:255',
            'parent_occupation' => 'required|string|max:255',
            'race' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|min:4|max:6',

            //Schedule Student Table
            'receipt' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            // dd($validator->errors()->all());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $studentDataExists = StudentInfo::where('user_id', Auth::user()->id)->exists();
        if (!$studentDataExists) {
            //If Not Already Exists -> Store to StudentInfo tbl
            $recordInfo = $request->user()->studentInfo()->create([
                'father_name' => $request->father_name,
                'mother_name' => $request->mother_name,
                'parent_phone' => $request->parent_phone,
                'parent_email' => $request->parent_email,
                'parent_occupation' => $request->parent_occupation,
                'race' => $request->race,
                'nationality' => $request->nationality,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'created_at' => now(),
            ]);
            if (!$recordInfo) {
                return redirect()->back()->with('error', 'Info Action Failed');
            }
        }


        $courseId = $schedule->course->id;
        $userId = Auth::user()->id;
        $courseAlreadyApplied = Schedule::where('course_id', $courseId)
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })->exists(); //Check if User is Applying for Same Course;

        if (!$courseAlreadyApplied) 
        {
            //Store to Schedule_student tbl
            try {
                $schedule->users()->attach(Auth::user()->id, ['receipt' => '-','created_at' => now()]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Action Failed');
            }
            $imagePath = $request->file('receipt')->store('images/receipts', 'public');
            $schedule->users()->updateExistingPivot(Auth::user()->id, ['receipt' => $imagePath]);

            return redirect()->route('courses.bysession', [
                'course' => $schedule->course->id,
                'session' => $schedule->session,
            ])->with('success', 'You have Enrolled the Course, Wait for an admin to Approve.');
        }
        return redirect()->route('courses.bysession', [
            'course' => $schedule->course->id,
            'session' => $schedule->session,
        ])->with('error', 'You have Already Enrolled the Course');
    }
}
