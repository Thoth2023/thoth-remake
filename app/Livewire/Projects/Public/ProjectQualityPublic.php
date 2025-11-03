<?php

namespace App\Livewire\Projects\Public;

use Livewire\Component;
use App\Models\Project;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Models\Project\Planning\QualityAssessment\GeneralScore;
use App\Models\Project\Planning\QualityAssessment\Cutoff;

class ProjectQualityPublic extends Component
{
    public $project;
    public $questions = [];
    public $ranges = [];
    public $cutoff;

    public function mount(Project $project)
    {
        $this->project = $project;

        $this->questions = Question::with('qualityScores')
            ->where('id_project', $project->id_project)
            ->get() ?? collect();

        $this->ranges = GeneralScore::where('id_project', $project->id_project)
            ->orderBy('start', 'asc')
            ->get() ?? collect();

        $this->cutoff = Cutoff::where('id_project', $project->id_project)->first();
    }

    public function render()
    {
        return view('livewire.projects.public.project-quality-public');
    }
}
