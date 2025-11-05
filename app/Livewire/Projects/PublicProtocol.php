<?php

namespace App\Livewire\Projects;

use App\Models\Domain;
use App\Models\Keyword;
use App\Models\ProjectDatabase;
use App\Models\ProjectLanguage;
use App\Models\ProjectStudyType;
use App\Models\Project\Planning\QualityAssessment\Question;
use App\Models\Project\Planning\QualityAssessment\GeneralScore;
use App\Models\Project\Planning\QualityAssessment\Cutoff;
use App\Models\SearchStrategy;
use Livewire\Component;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class PublicProtocol extends Component
{
    public $project;
    public $showModal = false;
    public $activeTab = 'protocol';

    protected $listeners = ['showPublicProtocol'];



    public function mount(Project $project)
    {
        $this->project = $project;
        // Obtém o ID do projeto a partir da URL

        $this->dispatch('setCurrentProjectForChildren', projectId: $project->id_project);
    }

    public function showPublicProtocol()
    {
        $this->showModal = true;
        //$this->dispatch('public-reports-attempt-render');
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $searchStrategy = $this->project->searchStrategy()->first();

        return view('livewire.projects.public-protocol', [
            'project' => $this->project,
            'searchStrategy' => $searchStrategy,
        ]);
    }
}
