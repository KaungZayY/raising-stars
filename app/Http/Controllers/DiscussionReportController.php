<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DiscussionReportController extends Controller
{
    public function index()
    {
        return view('reports.discussion-report');
    }
}
