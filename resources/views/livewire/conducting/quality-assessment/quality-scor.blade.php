<?php

namespace App\Livewire\Conducting\QualityAssessment;

use Livewire\Component;

class QualityScore extends Component
{
    public $status_paper = 'Unclassified'; // Pode ser Rejected, Accepted, etc
    public $score = null;
    public $quality_description = 'N/A';

    public function mount($paper = null, $projectId = null)
    {
        // Aqui você pode carregar os dados do paper se quiser
        // Por enquanto só vamos deixar fixo

        $this->status_paper = 'Accepted'; // Exemplo
        $this->score = 4.5; // Exemplo
        $this->quality_description = 'Alto nível de evidência'; // Exemplo
    }

    public function render()
    {
        return view('livewire.conducting.quality-assessment.quality-score');
    }
}
