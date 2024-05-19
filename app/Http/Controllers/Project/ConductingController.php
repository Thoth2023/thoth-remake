<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\View\View;

class ConductingController extends Controller
{
    public function index(string $id_project): View
    {
        $project = Project::findOrFail($id_project);
        return view('project.conducting.index', compact('project'));
    }
}
