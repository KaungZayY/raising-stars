<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleApplyController extends Controller
{
    public function scheduleView()
    {
        return view('apply.schedule-apply');
    }
}
