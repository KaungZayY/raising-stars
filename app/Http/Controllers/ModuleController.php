<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::autosort()->with('subject')->with('lecturers')->get();
        return view('module.module-list',['modules'=>$modules]);
    }

    public function create($course_id = null)
    {
        $subjects = Subject::all();
        $lecturers = User::where('role_id',2)->get();
        return view('module.module-create',['subjects'=>$subjects,'lecturers'=>$lecturers, 'course_id'=>$course_id]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'module_number' => 'required|max:12|unique:modules,module_number',
            'subject_id' => 'required|exists:subjects,id',
            'lecturers' => 'required|array',
            'lecturers.*' => 'exists:users,id',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with('error','Cannot add New Module or Module Already Exists');
        }
        
        $module = Module::create([
            'module_number' => $request->module_number,
            'subject_id'    => $request->subject_id,
        ]);

        if(!$module)
        {
            return redirect()->back()->with('error','Action Failed');
        }

        $module->lecturers()->sync($request->input('lecturers', []));       //add data to many-to-many relationship tbl
        if($request->course_id != null)
        {
            return redirect()->route('course.moduleadd',$request->course_id)->with('success','New Module Added');
        }
        return redirect()->route('module')->with('success','New Module Added');
    }

    public function edit(Module $module)
    {
        $subjects = Subject::all();
        $lecturers = User::where('role_id',2)->get();
        return view('module.module-edit',['module'=>$module,'subjects'=>$subjects,'lecturers'=>$lecturers]);
    }

    public function update(Request $request, Module $module)
    {
        $validator = Validator::make($request->all(),[
            'module_number' => 'required|max:12|unique:modules,module_number,'.$module->id,
            'subject_id' => 'required|exists:subjects,id',
            'lecturers' => 'required|array',
            'lecturers.*' => 'exists:users,id',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->with('error','Cannot Update Module or Module Already Exists');
        }

        $updated = $module->update([
            'module_number' => $request->module_number,
            'subject_id' => $request->subject_id,
        ]);

        if(!$updated)
        {
            return redirect()->back()->with('error','Update Action Failed');
        }
        else
        {
            $module->lecturers()->sync($request->input('lecturers', []));
            return redirect()->route('module')->with('success','Update Successful');
        }
    }

    public function destroy(Module $module)
    {
        // dd($module);
        $deleted = $module->delete();
        if(!$deleted)
        {
            return redirect()->back()->with('error','Cannot Archive this Module');
        }
        return redirect()->route('module')->with('success','Module Archived');
    }

    public function archives()
    {
        $modules = Module::onlyTrashed()->get();
        return view('module.module-archives',['modules'=>$modules]);
    }

    public function restore($id)
    {
        $module = Module::onlyTrashed()->findOrFail($id);
        $module->restore();
        return redirect()->route('module')->with('success','Module Restored');
    }

    public function forcedelete($id)
    {
        $module = Module::withTrashed()->findOrFail($id);
        $module->forceDelete();
        return redirect()->route('module.archives')->with('success','Module Deleted Permanently');
    }
}
