<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::autosort()->get();
        return view('subject.subject-list',['subjects'=>$subjects]);
    }

    public function create()
    {
        return view('subject.subject-create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'subject' => 'required|unique:subjects,subject,NULL,NULL,subject,' . strtolower($request->subject),//case insensitive validation
        ]);
        if($validator->fails()){
            return redirect()->back()->with('error','Adding New Subject Failed or Subject Already Exists');
            exit();
        }

        //Db Transaction Start
        DB::beginTransaction();
        try
        {
            $subject = new Subject();
            $subject->subject = $request->subject;
            $subject->created_at = now();
            $subject->updated_at = now();
            $saved = $subject->save();
            if(!$saved)
            {
                throw new \Exception('Error Saving Subject.');
            }
            DB::commit();
            return redirect()->route('subject')->with('success', 'You have Added New Subject');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with('error','Cannot Add New Subject');
        }
    }

    public function edit(Subject $subject)
    {
        return view('subject.subject-edit',['subject'=>$subject]);
    }

    public function update(Request $request, Subject $subject)
    {
        // dd($request);
        $validator = Validator::make($request->all(),[
            'subject' => 'required|unique:subjects,subject,' . $subject->id . ',id,subject,' . strtolower($request->subject),
        ]);
        if($validator->fails()){
            return redirect()->back()->with('error','Adding New Subject Failed or Subject Already Exists');
            exit();
        }
        
        //Update DB transaction
        DB::beginTransaction();
        try
        {
            $subject->subject = $request->subject;
            $subject->updated_at = now();
            $updated = $subject->save();
            if(!$updated)
            {
                throw new \Exception('Error Updating Subject.');
            }
            DB::commit();
            return redirect()->route('subject')->with('success', 'Subject has Updated');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with('error','Subject Update Failed');
        }
    }

    public function destroy(Subject $subject)
    {
        try {
            // Check if there are related records in the modules table
            if ($subject->modules()->exists()) {
                return redirect()->route('subject')->with('error', 'Cannot delete this subject. It has related modules.');
            }

            // Soft delete the subject
            $deleted = $subject->delete();

            if (!$deleted) {
                return redirect()->route('subject')->with('error', 'Cannot delete this subject.');
            }

            return redirect()->route('subject')->with('success', 'Subject deleted successfully.');
        } 
        catch (ModelNotFoundException $e) 
        {
            return redirect()->route('subject')->with('error', 'Subject not found.');
        }
    }

    public function archives()
    {
        $subjects = Subject::onlyTrashed()->get();
        return view('subject.subject-archives',['subjects'=>$subjects]);
    }

    public function restore($id)
    {
        $subject = Subject::withTrashed()->find($id);
        $subject->restore();
        return redirect()->route('subject')->with('success', 'You had Restored the Subject'); 
    }

    public function forcedelete($id)
    {
        $subject = Subject::withTrashed()->find($id);
        $subject->forceDelete();
        return redirect()->route('subject.archives')->with('success', 'Deleted'); 
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output="";
            $subjects=DB::table('subjects')->whereNull('deleted_at')->where('subject','LIKE','%'.$request->search."%")->get();

            if($subjects)
            {
                $counter = 1;
                foreach ($subjects as $key => $subject) {
                    $output.=
                    '<tr>'.
                        '<td class="py-2 px-4 border-b text-center">'.$counter.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.$subject->subject.'</td>'.
                        '<td class="py-2 px-4 border-b text-center">'.
                            '<div class="inline-block">'.
                                '<form action="'.route('subject.edit',$subject->id).'" method="GET">'.
                                    '<button>
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                                            <path fill="#22C55E" d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/>
                                        </svg>
                                    </button>'.
                                '</form>'.
                            '</div>'.
                            '<span class="ml-2 mr-2">|</span>'.
                            '<div class="inline-block">'.
                                '<form action="'.route('subject.delete',$subject->id).'" method="POST" onsubmit="return confirm(\'Move this Data to Archives?\');">' .
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
