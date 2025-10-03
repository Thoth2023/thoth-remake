<?php

namespace App\Http\Controllers\Project\Conducting;

use App\Http\Controllers\Controller;
use App\Models\BibUpload;
use App\Utils\CheckProjectDataPlanning;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Services\ConductingProgressService;

class ConductingController extends Controller
{
    protected ConductingProgressService $progressService;

    public function __construct(ConductingProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    public function index(string $id_project): View|RedirectResponse
    {
        $project = Project::findOrFail($id_project);

        // Verificação de autorização
        if (Gate::denies('access-project', $project)) {
            return redirect()->route('projects.index')
                ->with('error', 'Você não tem permissão para acessar este projeto.');
        }

        // Consulta projetos que têm snowballing
        $snowballing_projects = Project::where('feature_review', 'snowballing')->get();

        // Data Extraction Questions
        $dataExtractionQuestions = $project->dataExtractionQuestions()->get();
        $questions = [];
        foreach ($dataExtractionQuestions as $question) {
            $options = $question->options()->pluck('description')->toArray();
            $questions[] = [
                'id' => $question->id,
                'description' => $question->description,
                'type' => $question->type,
                'options' => $options,
            ];
        }

        // Estudos importados
        $bibUploads = BibUpload::all();
        $studies = collect();
        foreach ($bibUploads as $bib) {
            $projectDB = $bib->projectDatabase()->first();
            if ($projectDB && $projectDB->id_project == $id_project) {
                $studies = $studies->merge($bib->studies()->get());
            }
        }

        // Verificação de campos do Planning
        CheckProjectDataPlanning::checkProjectData($id_project);

        // Bases de dados do projeto
        $databases = $project->databases()->get();

        // Progresso da etapa de conducting
        $conductingProgress = $this->progressService->calculateProgress($project->id_project);

        return view('project.conducting.index', [
            'project' => $project,
            'studies' => $studies,
            'databases' => $databases,
            'snowballing_projects' => $snowballing_projects,
            'dataExtractionQuestions' => $questions,
            'conductingProgress' => $conductingProgress,
        ]);
    }

    public function setActiveTab(Request $request)
    {
        $activeTab = $request->input('activeTab');
        session(['activePlanningTab' => $activeTab]);
        return response()->json(['status' => 'success']);
    }
}
