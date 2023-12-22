<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
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
        // dd($subject);
        $deleted = $subject->delete();
        if(!$deleted)
        {
            DB::rollBack();
            return redirect()->route('subject')->with('error','Cannot Delete this Subject');
        }
        else
        {
            return redirect()->route('subject')->with('success', 'You had Deleted the Subject'); 
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
        return redirect()->route('subject')->with('success', 'Deleted'); 
    }
}
