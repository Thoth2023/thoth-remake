<?php

namespace App\Livewire\Conducting\QualityAssessment;

use App\Models\Member;
use App\Models\Project;
use App\Models\Project\Conducting\QualityAssessment\PapersQA;
use Livewire\Attributes\On;
use Livewire\Component;

class QualityScore extends Component
{
    public $currentProject;
    public $projectId;
    public $paper;
    public $quality_description;
    public $score;
    public $status_paper;


    public function mount($paper,$projectId)
    {
        $this->projectId = $projectId; // Usar o projectId passado diretamente
        $this->currentProject = Project::find($this->projectId);

        $this->paper = $paper;
        $this->loadScore();
    }

    #[On('show-success-quality-score')]
    #[On('show-success-quality')]
    #[On('reload-paper-modal')]
    public function loadScore()
    {
        // Buscar o membro específico para o projeto atual
        $member = Member::where('id_user', auth()->user()->id)
            ->where('id_project',$this->currentProject->id_project) // Certificar-se de que o membro pertence ao projeto atual
            ->first();

        $StatusQuality = PapersQA::where('papers_qa.id_paper', $this->paper)
            ->join('general_score', 'papers_qa.id_gen_score', '=', 'general_score.id_general_score')
            ->join('papers', 'papers_qa.id_paper', '=', 'papers.id_paper')
            ->join('status_qa', 'papers_qa.id_status', '=', 'status_qa.id_status')
            ->select('papers_qa.*','general_score.description as quality_description','papers_qa.score','status_qa.status as status_paper')
            ->where('id_member', $member->id_members)
            ->first();


        if ($StatusQuality) {
            $this->quality_description = $StatusQuality->quality_description;
            $this->score = $StatusQuality->score;
            $this->status_paper = $StatusQuality->status_paper;
        } else {
            $this->quality_description = 'Unknown';
            $this->score = null;
        }
    }

    public function render()
    {
        return view('livewire.conducting.quality-assessment.quality-score');
    }
}
