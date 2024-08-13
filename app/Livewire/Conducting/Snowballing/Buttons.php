<?php

namespace App\Livewire\Conducting\Snowballing;

use App\Models\BibUpload;
use App\Models\Project\Conducting\Papers;
use App\Models\ProjectDatabases;
use App\Utils\ActivityLogHelper as Log;
use Livewire\Component;
use TCPDF;
use App\Utils\ToastHelper;


class Buttons extends Component
{

    public $projectId;

    public function removeDuplicates()
    {
        // Obtém todos os papers para o projeto atual
        $papers = $this->getPapers($this->projectId);

        // Inicializa arrays para armazenar títulos únicos e duplicados
        $uniqueTitles = [];
        $duplicates = [];

        // Itera sobre os papers para encontrar duplicatas
        foreach ($papers as $paper) {
            if (!in_array($paper->title, $uniqueTitles)) {
                // Adiciona título à lista de títulos únicos
                $uniqueTitles[] = $paper->title;
            } else {
                // Adiciona o ID do papel à lista de duplicados
                $duplicates[] = $paper->id_paper;
            }
        }

        // Log para verificar IDs de duplicados
        //Log::info('Duplicate IDs:', $duplicates);


        // Atualiza o status dos papers duplicados para 'removed' (status_selection = 5)
        if (count($duplicates) > 0) {
            $updated = Papers::whereIn('id_paper', $duplicates)
                ->update(['status_selection' => 4]); // Atualiza o campo status_selection para '5'

            // Log para verificar o número de atualizações realizadas
            //Log::info('Number of papers updated:', ['count' => $updated]);


            // Log da atividade com o número de papers duplicados
            Log::logActivity(
                action: 'Papers duplicated have been successfully marked as Duplicated',
                description: 'Number of papers duplicates: ' . $updated,
                projectId: $this->projectId,
            );


            // Emite um evento para recarregar o componente Livewire
            $this->dispatch('refreshPapers');

            if ($updated > 0) {
                $this->toast('Papers duplicated have been successfully marked as Duplicated.', 'success');
            } else {
                $this->toast('No papers were updated.', 'info');
            }
        } else {
            $this->toast('No duplicates found.', 'info');
        }
    }

    public function toast(string $message, string $type)
    {
        $this->dispatch('buttons', ToastHelper::dispatch($type, $message));
    }

    public function exportCsv()
    {
        $papers = $this->getPapers($this->projectId);
        $csvData = $this->formatCsv($papers);
        return response()->streamDownload(function() use ($csvData) {
            echo $csvData;
        }, 'studies.csv');
    }

    public function exportXml()
    {
        $papers = $this->getPapers($this->projectId);
        $xmlData = $this->formatXml($papers);
        return response()->streamDownload(function() use ($xmlData) {
            echo $xmlData;
        }, 'studies.xml');
    }

    public function exportPdf()
    {

        $papers = $this->getPapers($this->projectId);
        $pdfData = $this->formatPdf($papers);
        return response()->streamDownload(function() use ($pdfData) {
            echo $pdfData;
        }, 'studies.pdf');
    }

    private function getPapers()
    {
        $idsDatabase = ProjectDatabases::where('id_project', $this->projectId)->pluck('id_project_database');

        $idsBib = [];
        if (count($idsDatabase) > 0) {
            $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();
        }

        return Papers::whereIn('id_bib', $idsBib)->get();
    }

    private function formatCsv($papers)
    {
        $csvData = "ID,Title, Acceptance Criteria, Rejection Criteria, Database, Status\n";

        foreach ($papers as $paper) {
            $criteriaAcceptance = $paper->criteriaAcceptance ?? '';
            $criteriaRejection = $paper->criteriaRejection ?? '';
            $database = $paper->data_base->name ?? '';
            $status = $paper->status_criteria->description ?? '';

            $csvData .= "{$paper->id},{$paper->title},$criteriaAcceptance,$criteriaRejection,$database,$status\n";
        }

        return $csvData;
    }

    private function formatXml($papers)
    {
        $xmlData = new \SimpleXMLElement('<papers/>');

        foreach ($papers as $paper) {
            $paperElement = $xmlData->addChild('paper');
            $paperElement->addChild('id', $paper->id);
            $paperElement->addChild('title', $paper->title);
            $paperElement->addChild('criteria_acceptance', $paper->criteriaAcceptance ?? '');
            $paperElement->addChild('criteria_rejection', $paper->criteriaRejection ?? '');
            $paperElement->addChild('database', $paper->database->name ?? '');
            $paperElement->addChild('status', $paper->status ?? '');

        }

        return $xmlData->asXML();
    }

    private function formatPdf($papers)
    {
        $pdf = new TCPDF();
        $pdf->AddPage();

        $html = '<h1>Study Selection</h1>';
        $html .= '<table border="1" cellpadding="2" cellspacing="2">';
        $html .= '<thead><tr><th>ID</th><th>Title</th><th>Acceptance Criteria</th><th>Rejection Criteria</th><th>Database</th><th>Status</th></tr></thead><tbody>';

        foreach ($papers as $paper) {
            $criteriaAcceptance = $paper->criteriaAcceptance ?? '';
            $criteriaRejection = $paper->criteriaRejection ?? '';
            $database = $paper->database->name ?? '';
            $status = $paper->status->description ?? '';

            $html .= "<tr><td>{$paper->id}</td><td>{$paper->title}</td><td>$criteriaAcceptance</td><td>$criteriaRejection</td><td>$database</td><td>$status</td></tr>";
        }

        $html .= '</tbody></table>';

        $pdf->writeHTML($html, true, false, true, false, '');

        return $pdf->Output('studies.pdf', 'S');
    }


    public function mount() {
        $this->projectId = request()->segment(2);
    }

    public function render()
    {
        return view('livewire.conducting.snowballing.buttons');
    }
}
