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
        ->select('courses.course','schedules.*','users.name','users.email','schedule_student.status')
        ->get();
        // dd($pendings);
        return view('pending.pending-list',compact('pendings'));
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $pendings = DB::table('schedule_student')->where('status', 'pending')
                        ->join('schedules', 'schedule_student.schedule_id', '=', 'schedules.id')
                        ->join('users', 'schedule_student.user_id', '=', 'users.id')
                        ->join('courses', 'schedules.course_id', '=', 'courses.id')
                        ->where('users.name','like', '%' . $request->search . '%')
                        ->select('courses.course','schedules.*','users.name','users.email','schedule_student.status')
                        ->get();

            if($pendings)
            {
                $counter = 1;
                foreach ($pendings as $key => $pending) {
                    $output.=
                    '<tr>'.
                        '<td class="py-2 px-4 border-b text-center">'.$counter.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$pending->course.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$pending->session.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$pending->start_date.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$pending->end_date.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$pending->name.'</td>'.
                        '<td class="py-2 px-4 border-b text-center text-yellow-700">'.$pending->status.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$pending->email.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.
                            '<div class="inline-block">'.
                                '<form action="#" method="GET">'.
                                    '<button>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 512 512">
                                            <path fill="#22c55e" d="M0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM281 385c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l71-71L136 280c-13.3 0-24-10.7-24-24s10.7-24 24-24l182.1 0-71-71c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L393 239c9.4 9.4 9.4 24.6 0 33.9L281 385z"/>
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
}
