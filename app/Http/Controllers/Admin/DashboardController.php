<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Type;

class DashboardController extends Controller
{

    public function index()
    {
        $projects = Project::all();
        $types = Type::all();
        return view('admin.dashboard', compact('projects', 'types'));
    }
}
