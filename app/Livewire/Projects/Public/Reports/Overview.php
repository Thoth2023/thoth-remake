<?php

namespace App\Livewire\Projects\Public\Reports;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Activity;
use App\Models\Project;
use App\Models\Project\Conducting\Papers;

class Overview extends Component
{
    public $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function getProjectActivities()
    {
        $activitiesPerUser = Activity::with('user')
            ->where('id_project', $this->project->id_project)
            ->selectRaw('users.firstname as user_name, COUNT(activity_log.id_log) as total_activities, DATE(activity_log.created_at) as activity_date')
            ->join('users', 'activity_log.id_user', '=', 'users.id')
            ->groupBy('user_name', 'activity_date')
            ->orderBy('activity_date')
            ->get();

        $dates = $activitiesPerUser->pluck('activity_date')->unique();

        $activitiesByUser = $activitiesPerUser->groupBy('user_name')->map(fn ($group) =>
        $dates->map(fn ($date) =>
            $group->firstWhere('activity_date', $date)->total_activities ?? 0
        )
        );

        $projectTotalActivities = $dates->map(fn ($date) =>
        $activitiesPerUser->where('activity_date', $date)->sum('total_activities')
        );

        return [
            'dates' => $dates,
            'activitiesByUser' => $activitiesByUser,
            'projectTotalActivities' => $projectTotalActivities,
        ];
    }

    public function getImportedStudiesCount()
    {
        return Papers::whereHas('bibUpload', fn ($q) =>
        $q->whereHas('projectDatabase', fn ($q) =>
        $q->where('id_project', $this->project->id_project)
        )
        )->count();
    }

    public function getDuplicateStudiesCount()
    {
        return Papers::whereHas('bibUpload', fn ($q) =>
        $q->whereHas('projectDatabase', fn ($q) =>
        $q->where('id_project', $this->project->id_project)
        )
        )->where('status_selection', 4)->count();
    }

    public function getStudiesSelectionCount()
    {
        return Papers::whereHas('bibUpload', fn ($q) =>
        $q->whereHas('projectDatabase', fn ($q) =>
        $q->where('id_project', $this->project->id_project)
        )
        )->where('status_selection', 1)->count();
    }

    public function getStudiesSelectionRejectedCount()
    {
        return Papers::whereHas('bibUpload', fn ($q) =>
        $q->whereHas('projectDatabase', fn ($q) =>
        $q->where('id_project', $this->project->id_project)
        )
        )->where('status_selection', 2)->count();
    }

    public function getStudiesQualityCount()
    {
        return Papers::whereHas('bibUpload', fn ($q) =>
        $q->whereHas('projectDatabase', fn ($q) =>
        $q->where('id_project', $this->project->id_project)
        )
        )->where('status_qa', 1)->count();
    }

    public function getStudiesQualityRejectedCount()
    {
        return Papers::whereHas('bibUpload', fn ($q) =>
        $q->whereHas('projectDatabase', fn ($q) =>
        $q->where('id_project', $this->project->id_project)
        )
        )->where('status_qa', 2)->count();
    }

    public function getStudiesExtractionCount()
    {
        return Papers::whereHas('bibUpload', fn ($q) =>
        $q->whereHas('projectDatabase', fn ($q) =>
        $q->where('id_project', $this->project->id_project)
        )
        )->where('status_extraction', 1)->count();
    }

    public function render()
    {
        $activitiesData = $this->getProjectActivities();

        $importedStudiesCount = $this->getImportedStudiesCount();
        $duplicateStudiesCount = $this->getDuplicateStudiesCount();
        $studiesSelectionCount = $this->getStudiesSelectionCount();
        $studiesSelectionRejectedCount = $this->getStudiesSelectionRejectedCount();
        $studiesQualityCount = $this->getStudiesQualityCount();
        $studiesQualityRejectedCount = $this->getStudiesQualityRejectedCount();
        $studiesExtractionCount = $this->getStudiesExtractionCount();

        $notDuplicateStudiesCount = $importedStudiesCount - $duplicateStudiesCount;

        return view('livewire.projects.public.reports.overview', compact(
            'activitiesData',
            'importedStudiesCount',
            'duplicateStudiesCount',
            'notDuplicateStudiesCount',
            'studiesSelectionCount',
            'studiesQualityCount',
            'studiesExtractionCount',
            'studiesQualityRejectedCount',
            'studiesSelectionRejectedCount'
        ));

    }
}
