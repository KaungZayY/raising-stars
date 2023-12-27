<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = User::where('role_id',2)->autosort()->get();
        return view('lecturer.lecturer-list',['lecturers'=>$lecturers]);
    }

    public function create()
    {
        return view('lecturer.lecturer-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['required', 'string', 'min:8','max:11'],
            'address' => ['required', 'string','min:3', 'max:255'],

        ]);
        // dd($request);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'role_id' => 2,
        ]);

        if(!$user)
        {
            return redirect()->back()->with('error','Cannot Add this User');
        }
        return redirect()->route('lecturer')->with('success', 'New Lecturer Added');  
    }

    public function edit(User $user)
    {
        return view('lecturer.lecturer-edit',['lecturer'=>$user]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone_number' => ['required', 'string', 'min:8','max:11'],
            'address' => ['required', 'string','min:3', 'max:255'],
        ]);
        // dd($request);
        //Update DB transaction
        DB::beginTransaction();
        try
        {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->address = $request->address;
            $user->updated_at = now();
            $updated = $user->save();
            if(!$updated)
            {
                throw new \Exception('Error Updating User.');
            }
            DB::commit();
            return redirect()->route('lecturer')->with('success', 'Information has Updated');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with('error','Update Failed');
        }
        
    }

    public function destroy(User $user)
    {
        $deleted = $user->delete();
        if(!$deleted)
        {
            DB::rollBack();
            return redirect()->route('lecturer')->with('error','Cannot Remove this User');
        }
        else
        {
            return redirect()->route('lecturer')->with('success','User Archived');
        }
    }

    public function archives()
    {
        $lecturers = User::onlyTrashed()->where('role_id',2)->get();
        return view('lecturer.lecturer-archives',['lecturers'=>$lecturers]);
    }

    public function restore($id)
    {
        $lecturer = User::withTrashed()->findOrFail($id);
        $lecturer->restore();
        return redirect()->route('lecturer.archives')->with('success','User Restored');
    }

    public function forcedelete($id)
    {
        $lecturer = User::withTrashed()->findOrFail($id);
        $lecturer->forcedelete();
        return redirect()->route('lecturer.archives')->with('success','User Removed Permanently');
    }
}
