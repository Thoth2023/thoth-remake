<?php

namespace App\Http\Controllers\Project\Conducting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\View\View;

class ConductingController extends Controller
{
    public function index(string $id_project): View
    {
        $project = Project::findOrFail($id_project);


        // Consulta para obter os projetos que têm a feature review snowballing
        $snowballing_projects = Project::where('feature_review', 'snowballing')->get();

        //Consulta que possui as Data Extraction Questions
        $dataExtractionQuestions = $project->dataExtractionQuestions()->get();

        return view('project.conducting.index', compact('project',  'snowballing_projects'), compact('dataExtractionQuestions'));


    }
}
