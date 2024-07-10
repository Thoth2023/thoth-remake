<?php

namespace App\Http\Controllers\Project\Conducting;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class DataExtractionController extends Controller
{

    public function index(string $id_project) {
        $project = Project::findOrFail($id_project);
        $questions = $project->dataExtractionQuestions()->get();
        return view('project.conducting.data-extraction', compact('project'), compact('questions'));
    }
    
}
