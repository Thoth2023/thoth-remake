<?php

namespace App\Http\Controllers\Project\Conducting;

use App\Http\Controllers\Controller;
use App\Models\BibUpload;
use App\Models\Member;
use App\Models\Project;
use App\Services\ConductingProgressService;
use App\Utils\CheckProjectDataPlanning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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

        // Verificação de permissão
        if (Gate::denies('access-project', $project)) {
            return redirect()->route('projects.index')
                ->with('error', 'Você não tem permissão para acessar este projeto.');
        }

        // Verificação do planejamento (Planning)
        CheckProjectDataPlanning::checkProjectData($id_project);

        // Exibir modal somente se o protocolo estiver completo e ainda não aceito
        if (!$project->protocol_warning_ack) {
            session(['show_protocol_warning_modal' => true]);
            Log::info('Modal de protocolo será exibido', ['project_id' => $id_project]);
        } else {
            session()->forget('show_protocol_warning_modal');
        }

        // Outras informações
        $databases = $project->databases()->get();
        $snowballing_projects = Project::where('feature_review', 'snowballing')->get();
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

        $bibUploads = BibUpload::all();
        $studies = collect();
        foreach ($bibUploads as $bib) {
            $projectDB = $bib->projectDatabase()->first();
            if ($projectDB && $projectDB->id_project == $id_project) {
                $studies = $studies->merge($bib->studies()->get());
            }
        }

        $conductingProgress = $this->progressService->calculateProgress($project->id_project);

        // 🔍 Obter o Member (e descobrir se é REVISOR)
        $member = Member::where('id_user', auth()->id())
            ->where('id_project', $id_project)
            ->first();

        $isReviewer = $member && $member->level == 4;

        return view('project.conducting.index', [
            'project' => $project,
            'studies' => $studies,
            'databases' => $databases,
            'snowballing_projects' => $snowballing_projects,
            'dataExtractionQuestions' => $questions,
            'conductingProgress' => $conductingProgress,
            'isReviewer' => $isReviewer,
        ]);
    }

    public function acceptProtocolWarning(Request $request)
    {
        $user = Auth::user();
        $projectId = $request->input('project_id');

        if ($user && $projectId) {
            $project = Project::find($projectId);
            Log::info('Verificando projeto', [
                'projectId' => $projectId,
                'existe' => (bool)$project,
            ]);

            if ($project && Gate::allows('access-project', $project)) {
                $project->protocol_warning_ack = true;
                $project->save();

                Log::info('Protocolo aceito com sucesso (persistido no banco)', [
                    'project_id' => $projectId,
                    'protocol_warning_ack' => $project->protocol_warning_ack,
                ]);

                return response()->json(['success' => true]);
            }

            Log::warning('Acesso negado ou projeto não encontrado', [
                'projectId' => $projectId,
            ]);
        }

        Log::error('Falha ao aceitar protocolo', [
            'user' => $user ? $user->id : null,
            'project_id' => $projectId,
        ]);

        return response()->json(['success' => false], 401);
    }

    public function setActiveTab(Request $request)
    {
        $activeTab = $request->input('activeTab');
        session(['activePlanningTab' => $activeTab]);
        return response()->json(['status' => 'success']);
    }
}
