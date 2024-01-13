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

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $user_id = Auth()->user()->id;
            $courses = DB::table('schedule_student')
                ->where('user_id', $user_id)
                ->join('schedules', 'schedule_student.schedule_id', '=', 'schedules.id')
                ->join('courses', 'schedules.course_id', '=', 'courses.id')
                ->where('courses.course','like', '%' . $request->search . '%')
                ->select('courses.course','schedules.start_date',
                'schedules.end_date','schedules.session','schedule_student.status',
                'schedule_student.created_at','schedule_student.updated_at')
                ->get();

            if($courses)
            {
                $counter = 1;
                foreach ($courses as $key => $course) {
                    $output.=
                    '<tr>'.
                        '<td class="py-2 px-4 border-b text-center">'.$counter.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$course->course.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$course->start_date.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$course->end_date.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$course->session.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$course->created_at.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$course->updated_at.'</td>'.
                        '<td class="py-2 px-4 border-b text-center text-white" style="background-color: ' . ($course->status === 'rejected' ? 'red' : ($course->status === 'approved' ? 'green' : 'yellow')) . ';">' . $course->status . '</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.
                            '<div class="inline-block">'.
                                '<form action="#" method="GET">'.
                                    '<button>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                            <path fill="#000000" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/>
                                        </svg>
                                    </button>'.
                                '</form>'.
                            '</div>'.
                        '</td>'.
                    '</tr>';
                    $counter++;
                }
                return Response($output);
            }
            
        }
    }

    public function myCourses()
    {
        $user_id = Auth()->user()->id;
        $courses = DB::table('schedule_student')->where('user_id', $user_id)
        ->join('schedules', 'schedule_student.schedule_id', '=', 'schedules.id')
        ->join('courses', 'schedules.course_id', '=', 'courses.id')
        ->where('schedule_student.status','approved')
        ->select('courses.course','schedules.start_date','schedules.end_date','schedules.session')
        ->get();
        // dd($courses);
        return view('student-view.my-courses',compact('courses'));
    }

}
