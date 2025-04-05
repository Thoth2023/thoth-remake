<?php

namespace App\Livewire\Planning;

use Livewire\Component;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class PublicProtocol extends Component
{
    public $project;
    public $showModal = false;
    public $activeTab = 'protocol';

    protected $listeners = ['showPublicProtocol'];

    public function downloadPdf() // cuidado ao mexer nas funções auxiliares deste método, pois são usadas para a formatação do arquivo
    {
    try {
        $fileName = 'protocolo-' . $this->sanitizeFilename($this->project->title) . '.pdf';
        
        $html = view('livewire.planning.public-protocol-pdf', [
            'project' => $this->project
        ])->render();
        
        $html = $this->sanitizeHtml($html);
        
        $pdf = Pdf::loadHTML($html);
        
        $pdf->setPaper('a4');
        $pdf->setOptions([
            'isRemoteEnabled' => true,
            'isHtml5ParserEnabled' => true,
            'isFontSubsettingEnabled' => true,
            'defaultFont' => 'DejaVu Sans',
        ]);
        
        return response()->streamDownload(
            function() use ($pdf) {
                echo $pdf->output();
            },
            $fileName,
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    } catch (\Exception $e) {
        Log::error('Erro ao gerar PDF', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        session()->flash('error', 'Não foi possível gerar o PDF. Por favor, tente novamente.');
        return null;
    }
    }
    
    protected function sanitizeHtml($html)
    {
        $html = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $html);
        
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        
        return $html;
    }
    
    protected function sanitizeFilename($filename)
    {

        $filename = preg_replace('/[^a-zA-Z0-9_.-]/', '-', $this->removeAccents($filename));
        $filename = preg_replace('/-+/', '-', $filename); // Remove hífens duplicados
        $filename = trim($filename, '-'); // Remove hífens no início e fim
        return $filename;
    }
    
    protected function removeAccents($string)
    {
        if (!preg_match('/[\x80-\xff]/', $string)) {
            return $string;
        }
        
        $chars = [
            // Decomposições para Latin-1 Supplement
            'ª' => 'a', 'º' => 'o', 'À' => 'A', 'Á' => 'A',
            'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
            'Æ' => 'AE', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I',
            'Î' => 'I', 'Ï' => 'I', 'Ð' => 'D', 'Ñ' => 'N',
            'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
            'Ö' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U',
            'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 'ß' => 's',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
            'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
            'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
            'ý' => 'y', 'þ' => 'th', 'ÿ' => 'y'
        ];
        
        return strtr($string, $chars);
    }

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function showPublicProtocol()
    {
        $this->showModal = true;
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
        return view('livewire.planning.public-protocol', [
            'project' => $this->project,
        ]);
    }
}