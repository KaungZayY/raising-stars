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

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $modules = Module::autosort()->with('subject')->with('lecturers')->get();

            if($modules)
            {
                $counter = 1;
                foreach ($modules as $key => $module) {
                    $output.=
                    '<tr>'.
                        '<td class="py-2 px-4 border-b text-center">'.$counter.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$module->module_number.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$module->subject->subject.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.
                            '<p>';
                                $lecturerCount = count($module->lecturers);
                                foreach($module->lecturers as $key => $lecturer)
                                {
                                    $output.=   $lecturer->name;
                                    if($key < $lecturerCount - 1){
                                        $output.=   ', ';
                                    }
                                    $output.= '<br>';
                                }
                        $output.=        
                            '</p>'.
                        '</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.
                            '<div class="inline-block">'.
                                '<form action="'.route('module.edit',$module->id).'" method="GET">'.
                                    '<button>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                            <path fill="#22C55E" d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                                        </svg>
                                    </button>'.
                                '</form>'.
                            '</div>'.
                            '<span class="ml-2 mr-2">|</span>'.
                            '<div class="inline-block">'.
                                '<form action="'.route('module.delete',$module->id).'" method="POST" onsubmit="return confirm(\'Move this Data to Archives?\');">' .
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
}
