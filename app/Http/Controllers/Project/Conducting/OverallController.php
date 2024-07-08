<?php

namespace App\Http\Controllers\Project\Conducting;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

use Livewire\Component;
use App\Models\Project as ProjectModel;
use App\Models\Project\Planning\QualityAssessment\GeneralScore as GeneralScoreModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project\Planning\QualityAssessment\Question as QuestionsModel;
use App\Models\Project\Planning\QualityAssessment\QualityScore as QualityScoreModel;


class OverallController extends Controller
{
    public $generalscore = [];
    public $currentProject;

    public $score_rule;
    public $description;
    public $score;
    public $id_qa;

    public $projectId;

    public $currentQuestion;

    public $qualityscore;
    public $progress;

    public function index(string $id_project) {
    
        $project = Project::findOrFail($id_project);        
        $generalscore = GeneralScoreModel::where('id_project', $project->id_project)->get();
        
        $this->projectId = request()->segment(2);
        $this->currentQuestion = QuestionsModel::where('id_project', $this->projectId)->get()->toArray();
        $this->currentQualityScore = null;
    
        $projectId = request()->segment(2);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->currentGeneralScore = null;
        $this->generalscore = GeneralScoreModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();
    
        $currentQuestion = QuestionsModel::where('id_project', $this->projectId)->get();

        $progress = 50;

        // Pass $progress to the view
        return view('project.conducting.index', compact('project', 'generalscore', 'currentQuestion', 'progress'));

    }
    


    public function mount()
    {
        $projectId = request()->segment(2);

        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->currentProject = ProjectModel::findOrFail($projectId);
        $this->currentGeneralScore = null;
        $this->generalscore = GeneralScoreModel::where(
            'id_project',
            $this->currentProject->id_project
        )->get();

      
    }
    

}
