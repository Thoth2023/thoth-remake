<?php

namespace App\Livewire\Reporting;

use App\Models\Activity;
use App\Models\Paper;
use App\Models\Project as ProjectModel;
use App\Models\Project\Conducting\Papers;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Overview extends Component
{
    public $currentProject;

    public function mount()
    {
        // Obtém o ID do projeto a partir da URL
        $projectId = request()->segment(2); // Exemplo usando a URL, mas pode ser da sessão
        // Busca o projeto e lança uma exceção se não for encontrado
        $this->currentProject = ProjectModel::findOrFail($projectId);
    }
    public function getProjectActivities()
    {
        // Consulta para pegar a quantidade de atividades do projeto e por usuário
        $activitiesPerUser = Activity::with('user')
            ->where('id_project', $this->currentProject->id_project)
            ->selectRaw('users.firstname as user_name, COUNT(activity_log.id_log) as total_activities, DATE(activity_log.created_at) as activity_date')
            ->join('users', 'activity_log.id_user', '=', 'users.id')
            ->groupBy('user_name', 'activity_date')
            ->orderBy('activity_date') // Ordena pelas datas das atividades
            ->get();

        // Pegar as datas das atividades para o eixo X
        $dates = $activitiesPerUser->pluck('activity_date')->unique();

        // Mapear os resultados por usuário e também o total do projeto
        $activitiesByUser = $activitiesPerUser->groupBy('user_name')->map(function ($activityGroup) use ($dates) {
            return $dates->map(function ($date) use ($activityGroup) {
                // Para cada data, retornar o total de atividades ou 0
                return $activityGroup->firstWhere('activity_date', $date)->total_activities ?? 0;
            });
        });

        // Contagem total de atividades do projeto por data
        $projectTotalActivities = $dates->map(function ($date) use ($activitiesPerUser) {
            return $activitiesPerUser->where('activity_date', $date)->sum('total_activities');
        });

        return [
            'dates' => $dates,
            'activitiesByUser' => $activitiesByUser,
            'projectTotalActivities' => $projectTotalActivities,
        ];
    }

    public function getImportedStudiesCount()
    {
        // Conta o número de estudos importados para o projeto atual
        return Papers::whereHas('bibUpload', function ($query) {
            $query->whereHas('projectDatabase', function ($query) {
                $query->where('id_project', $this->currentProject->id_project);
            });
        })
            ->count();
    }

    public function getDuplicateStudiesCount()
    {
        // Conta o número de estudos duplicados (status_selection = 4)
        return Papers::whereHas('bibUpload', function ($query) {
            $query->whereHas('projectDatabase', function ($query) {
                $query->where('id_project', $this->currentProject->id_project);
            });
        })
            ->where('status_selection', 4)
            ->count();
    }

    public function getStudiesSelectionCount()
    {
        // Conta o número de estudos duplicados (status_selection = 4)
        return Papers::whereHas('bibUpload', function ($query) {
            $query->whereHas('projectDatabase', function ($query) {
                $query->where('id_project', $this->currentProject->id_project);
            });
        })
            ->where('status_selection', 1)
            ->count();
    }

    public function getStudiesSelectionRejectedCount()
    {
        // Conta o número de estudos duplicados (status_selection = 4)
        return Papers::whereHas('bibUpload', function ($query) {
            $query->whereHas('projectDatabase', function ($query) {
                $query->where('id_project', $this->currentProject->id_project);
            });
        })
            ->where('status_selection', 2)
            ->count();
    }

    public function getStudiesQualityCount()
    {
        // Conta o número de estudos duplicados (status_selection = 4)
        return Papers::whereHas('bibUpload', function ($query) {
            $query->whereHas('projectDatabase', function ($query) {
                $query->where('id_project', $this->currentProject->id_project);
            });
        })
            ->where('status_qa', 1)
            ->count();
    }



    public function getStudiesQualityRejectedCount()
    {
        // Conta o número de estudos duplicados (status_selection = 4)
        return Papers::whereHas('bibUpload', function ($query) {
            $query->whereHas('projectDatabase', function ($query) {
                $query->where('id_project', $this->currentProject->id_project);
            });
        })
            ->where('status_qa', 2)
            ->count();
    }

    public function getStudiesExtractionCount()
    {
        // Conta o número de estudos duplicados (status_selection = 4)
        return Papers::whereHas('bibUpload', function ($query) {
            $query->whereHas('projectDatabase', function ($query) {
                $query->where('id_project', $this->currentProject->id_project);
            });
        })
            ->where('status_extraction', 1)
            ->count();
    }


    public function render()
    {
        // Obtém os dados de atividades
        $activitiesData = $this->getProjectActivities();
        // Obtém a contagem de "Imported Studies"
        $importedStudiesCount = $this->getImportedStudiesCount();
        $duplicateStudiesCount = $this->getDuplicateStudiesCount();
        $studiesSelectionCount = $this->getStudiesSelectionCount();
        $studiesSelectionRejectedCount = $this->getStudiesSelectionRejectedCount();
        $studiesQualityCount = $this->getStudiesQualityCount();
        $studiesQualityRejectedCount = $this->getStudiesQualityRejectedCount();
        $studiesExtractionCount = $this->getStudiesExtractionCount();
        $notDuplicateStudiesCount = $importedStudiesCount - $duplicateStudiesCount;

        return view('livewire.reporting.overview', compact('activitiesData','importedStudiesCount',
            'duplicateStudiesCount', 'notDuplicateStudiesCount','studiesSelectionCount','studiesQualityCount','studiesExtractionCount',
            'studiesQualityRejectedCount','studiesSelectionRejectedCount'));
    }
}
