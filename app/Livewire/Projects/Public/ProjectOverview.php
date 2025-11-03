<?php

namespace App\Livewire\Projects\Public;

use Livewire\Component;
use App\Models\Project;
use App\Models\Domain;
use App\Models\ProjectLanguage;
use App\Models\ProjectStudyType;
use App\Models\Keyword;
use App\Models\ProjectDatabase;
use App\Models\Member;
use App\Models\StudyType;
use App\Models\Database;

class ProjectOverview extends Component
{
    public $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.projects.public.project-overview', [
            'domains'        => Domain::where('id_project', $this->project->id_project)->get(),
            'keywords' => Keyword::where('id_project', $this->project->id_project)
                ->select('description')
                ->distinct()
                ->get(),
            'languages' => ProjectLanguage::where('id_project', $this->project->id_project)
                ->join('language', 'language.id_language', '=', 'project_languages.id_language')
                ->select('language.description')
                ->distinct()
                ->get(),
            'studyTypes' => ProjectStudyType::where('id_project', $this->project->id_project)
                ->join('study_type', 'study_type.id_study_type', '=', 'project_study_types.id_study_type')
                ->select('study_type.description')
                ->distinct()
                ->get(),
            'databases'      => ProjectDatabase::where('id_project', $this->project->id_project)
                ->join('data_base', 'data_base.id_database', '=', 'project_databases.id_database')
                ->select('data_base.name')->get(),
            'members'        => Member::where('id_project', $this->project->id_project)
                ->join('users', 'users.id', '=', 'members.id_user')
                ->select('users.username','members.level')->get(),
        ]);
    }
}
