<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = User::where('role_id',2)->get();
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
}
