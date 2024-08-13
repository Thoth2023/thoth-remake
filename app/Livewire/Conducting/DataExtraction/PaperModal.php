<?php

namespace App\Livewire\Conducting\DataExtraction;

use App\Models\EvaluationCriteria;
use App\Models\Member;
use App\Models\Project;
use App\Models\Project\Conducting\Papers;
use App\Models\ProjectDatabases;
use App\Models\StatusExtraction;
use App\Models\StatusSelection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;

class PaperModal extends Component
{

    public $currentProject;
    public $projectId;
    public $paper;

    public $criterias;

    public $selected_criterias = [];

    public $selected_status = "None";

    public function save()
    {
        $member = Member::where('id_user', auth()->user()->id)->first();
        foreach ($this->selected_criterias as $criteria) {
            EvaluationCriteria::create([
                'id_paper' => $this->paper['id_paper'],
                'id_criteria' => $criteria,
                'id_member' => $member->id_members,
            ]);
        }

        $paper = Papers::where('id_paper', $this->paper['id_paper'])->first();
        $status = StatusExtraction::where('description', $this->selected_status)->first();
        $paper->status_extraction = $status->id_status;

        $paper->save();
        $this->dispatch('paperSaved', ['message' => 'Paper information updated successfully!', 'type' => 'success']);
        //$this->resetFields();

    }

    #[On('showPaperExtraction')]
    public function showPaperExtraction($paper, $criterias)
    {
        $this->criterias = $criterias;
        $this->paper = $paper;

        $databaseName = DB::table('data_base')
            ->where('id_database', $this->paper['data_base'])
            ->value('name');

        $this->paper['database_name'] = $databaseName;

        $this->dispatch('show-paper-extraction');
    }

    public function render()
    {
        return view('livewire.conducting.data-extraction.paper-modal');
    }
}
