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

    public function create()
    {
        $subjects = Subject::all();
        $lecturers = User::where('role_id',2)->get();
        return view('module.module-create',['subjects'=>$subjects,'lecturers'=>$lecturers]);
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
        return redirect()->route('module')->with('success','New Module Added');
    }
}
