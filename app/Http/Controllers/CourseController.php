<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::autosort()->get();
        return view('course.course-list',['courses'=>$courses]);
    }

    public function create()
    {
        return view('course.course-create');
    }

    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(),[
            'course' => 'required|unique:courses,course',
            'from_age' => 'required|numeric',
            'to_age' => 'required|numeric',
            'fees' => 'required|numeric',
        ]);
        
        if($validator->fails())
        {
            return redirect()->route('course')->with('error','Course already Exists or Action Failed');
        }

        $course = Course::create([
            'course' => $request->course,
            'from_age' => $request->from_age,
            'to_age' => $request->to_age,
            'fees' => $request->fees,
        ]);

        if(!$course)
        {
            return redirect()->back()->with('error','Action Failed');
        }

        return redirect()->route('course')->with('success','Course Added');
    }

    public function edit(Course $course)
    {
        return view('course.course-edit',['course'=>$course]);
    }

    public function update(Request $request, Course $course)
    {
        $validator = Validator::make($request->all(),[
            'course' => 'required|unique:courses,course,'.$course->id,
            'from_age' => 'required|numeric',
            'to_age' => 'required|numeric',
            'fees' => 'required|numeric',
        ]);

        if($validator->fails())
        {
            return redirect()->route('course')->with('error','Duplicated Course Or Action Failed');
        }

        $updated = $course->update([
            'course' => $request->course,
            'from_age' => $request->from_age,
            'to_age' => $request->to_age,
            'fees' => $request->fees,
        ]);

        if(!$updated)
        {
            return redirect()->back()->with('error','Update Action Failed');
        }
        else
        {
            return redirect()->route('course')->with('success','Update Successful');
        }
    }

    public function destroy(Course $course)
    {
        // dd($course);
        $deleted = $course->delete();
        if(!$deleted)
        {
            return redirect()->route('course')->with('error','Cannot Remove this Course');
        }
        return redirect()->route('course')->with('success','Course Archived');
    }

    public function archives()
    {
        $courses = Course::onlyTrashed()->get();
        return view('course.course-archives',['courses'=>$courses]);
    }

    public function restore($id)
    {
        $course = Course::onlyTrashed()->findOrFail($id);
        $course->restore();
        return redirect()->route('course')->with('success','Course Restored');
    }

    public function forcedelete($id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        $course->forceDelete();
        return redirect()->route('course.archives')->with('success','Course Deleted Permanently');
    }

    public function module($id)
    {
        $course = Course::with('modules')->findOrFail($id);
        return view('course.module-course-list',compact('course'));
    }

    public function moduleAdd($id)
    {
        $course = Course::findOrFail($id);
        $unassignedModules = Module::whereNotIn('id',$course->modules->pluck('id'))->get();
        return view('course.module-course-add',compact('course','unassignedModules'));
    }

    public function moduleRemove(Request $request,$id)
    {
        $course = Course::findOrFail($id);
        $removed = $course->modules()->detach($request->module_id);
        if(!$removed)
        {
            return redirect()->route('course.module',$id)->with('error','Cannot Remove this Module');
        }
        return redirect()->route('course.module',$id)->with('success','Module was Removed');
    }

    public function assign(Request $request)
    {
        $course = Course::findOrFail($request->input('course_id'));
        $assigned = $course->modules()->attach($request->input('module_id'));
        if(!$assigned)
        {
            return response()->json(['error' => 'You have already Assigned this Module or Action Failed']);
        }
        return response()->json(['success' => 'Module Added to the Course']);
    }

    public function unassign(Request $request)
    {
        $course = Course::findOrFail($request->input('course_id'));
        $unassigned = $course->modules()->detach($request->input('module_id'));
        if(!$unassigned)
        {
            return response()->json(['error' => 'Action Failed']);
        }
        return response()->json(['success' => 'Action Success']);
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $courses=DB::table('courses')->whereNull('deleted_at')->where('course','LIKE','%'.$request->search."%")->get();

            if($courses)
            {
                $counter = 1;
                foreach ($courses as $key => $course) {
                    $output.=
                    '<tr>'.
                        '<td class="py-2 px-4 border-b text-center">'.$counter.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$course->course.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$course->from_age.' - '.$course->to_age.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.
                            '<div class="inline-block">'.
                                '<form action="'.route('course.module',$course->id).'" method="GET">'.
                                    '<button>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 448 512">
                                            <path d="M96 0C43 0 0 43 0 96V416c0 53 43 96 96 96H384h32c17.7 0 32-14.3 32-32s-14.3-32-32-32V384c17.7 0 32-14.3 32-32V32c0-17.7-14.3-32-32-32H384 96zm0 384H352v64H96c-17.7 0-32-14.3-32-32s14.3-32 32-32zm32-240c0-8.8 7.2-16 16-16H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16zm16 48H336c8.8 0 16 7.2 16 16s-7.2 16-16 16H144c-8.8 0-16-7.2-16-16s7.2-16 16-16z"/>
                                        </svg>
                                    </button>'.
                                '</form>'.
                            '</div>'.
                            '<span class="ml-2 mr-2">|</span>'.
                            '<div class="inline-block">'.
                                '<form action="'.route('course.edit',$course->id).'" method="GET">'.
                                    '<button>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                            <path fill="#22C55E" d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                                        </svg>
                                    </button>'.
                                '</form>'.
                            '</div>'.
                            '<span class="ml-2 mr-2">|</span>'.
                            '<div class="inline-block">'.
                                '<form action="'.route('course.delete',$course->id).'" method="POST" onsubmit="return confirm(\'Move this Data to Archives?\');">' .
                                    '<input type="hidden" name="_token" value="' . csrf_token() . '">' .
                                    '<input type="hidden" name="_method" value="DELETE">' .
                                    '<button>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                                            <path fill="#EF4444" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
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

    public function availableCourses()
    {
        return view('courses-view.courses-list');
    }
}
