<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
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
        ]);
        
        if($validator->fails())
        {
            return redirect()->route('course')->with('error','Course already Exists or Action Failed');
        }

        $course = Course::create([
            'course' => $request->course,
            'from_age' => $request->from_age,
            'to_age' => $request->to_age,
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
        ]);

        if($validator->fails())
        {
            return redirect()->route('course')->with('error','Duplicated Course Or Action Failed');
        }

        $updated = $course->update([
            'course' => $request->course,
            'from_age' => $request->from_age,
            'to_age' => $request->to_age,
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
}
