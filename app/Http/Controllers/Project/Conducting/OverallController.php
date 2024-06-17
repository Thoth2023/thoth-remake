<?php

namespace App\Http\Controllers\Project\Conducting;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class OverallController extends Controller
{

    public function index(string $id_project) {

        $project = Project::findOrFail($id_project);
        return view('project.conducting.index', compact('project'));

    }


}
