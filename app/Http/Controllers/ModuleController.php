<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::autosort()->with('subject')->with('lecturers')->get();
        return view('module.module-list',['modules'=>$modules]);
    }
}
