<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Project\Planning\PlanningProgressController;
use App\Services\ConductingProgressService;

class SearchProjectController extends Controller
{
    private PlanningProgressController $progressCalculator;
    private ConductingProgressService $conductingProgress;

    public function __construct(
        PlanningProgressController $progressCalculator,
        ConductingProgressService $conductingProgress
    ) {
        $this->progressCalculator = $progressCalculator;
        $this->conductingProgress = $conductingProgress;
    }

    public function searchByTitleOrCreated(Request $request)
    {
        $user = Auth::user();
        $searchProject = $request->searchProject;

        $projects = Project::where(function($query) use ($user) {
            $query->whereHas('users', function($q) use ($user) {
                $q->where('id_user', $user->id)
                    ->where(function($q2) {
                        $q2->where('members.status', 'accepted')
                            ->orWhereNull('members.status');
                    });
            })
                ->orWhere('is_public', 1);
        })
            ->where(function($query) use ($searchProject) {
                $query->where('title', 'like', '%' . $searchProject . '%')
                    ->orWhere('created_by', 'like', '%' . $searchProject . '%');
            })
            ->get();

        // Calcular progresso para cada projeto (igual ao index)
        foreach ($projects as $project) {
            try {
                $planning = $this->progressCalculator->calculate($project->id_project);
                $conducting = $this->conductingProgress->calculateProgress($project->id_project);

                $project->progress_percent = round(
                    ($planning['overall'] * 0.30) +
                    ($conducting['overall'] * 0.70),
                    2
                );
            } catch (\Throwable $e) {
                $project->progress_percent = 0;
                $project->dbg_error = $e->getMessage();
            }
        }

        return view('projects.search-project', compact('projects', 'searchProject'));
    }
}
