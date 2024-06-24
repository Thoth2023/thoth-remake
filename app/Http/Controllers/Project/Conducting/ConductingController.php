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

        // Consulta que possui as Data Extraction Questions
        $dataExtractionQuestions = $project->dataExtractionQuestions()->get();
        // Iterar sobre as perguntas e coletar as opções
        $questions = [];
        foreach ($dataExtractionQuestions as $question) {
            $options = $question->options()->get()->pluck('description')->toArray();
            $questions[] = [
                'id' => $question->id, // Adicione os campos que deseja exibir na visão
                'description' => $question->description, // Exemplo de campo
                'type' => $question->type, // Exemplo de campo
                'options' => $options, // Array de opções
            ];
        }

        return view('project.conducting.index', [
            'project' => $project,
            'snowballing_projects' => $snowballing_projects,
            'dataExtractionQuestions' => $questions, // Passa as perguntas formatadas para a visão
        ]);
    }
}
