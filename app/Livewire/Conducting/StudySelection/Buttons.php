<?php

namespace App\Livewire\Conducting\StudySelection;

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
    public $duplicates = []; // Armazena os papers duplicados organizados por título
    public $uniquePapers = []; // Armazena os papers únicos

    public function removeDuplicates()
    {
        $papers = $this->getPapers($this->projectId);
        $uniqueTitles = [];
        $duplicates = [];

        foreach ($papers as $paper) {
            if (!in_array($paper->title, $uniqueTitles)) {
                $uniqueTitles[] = $paper->title;
                $this->uniquePapers[] = $paper;
            } else {
                $this->duplicates[$paper->title][] = $paper;
            }
        }

        if (count($this->duplicates) > 0) {
            // Abrir o modal com os resultados
            $this->dispatch('show-duplicates-modal');
        } else {
            $this->toast('No duplicates found.', 'info');
        }
    }

    public function confirmDuplicate($paperId)
    {
        $paper = Papers::find($paperId);
        if ($paper) {
            $paper->update(['status_selection' => 4]); // Status 'Duplicated'
            $this->toast("Paper ID {$paperId} marked as duplicated.", 'success');
            // Log da atividade com o número de papers duplicados
            Log::logActivity(
                action: 'Paper duplicated have been successfully marked as Duplicated',
                description: 'Papers duplicate confirmed. - '.$paperId,
                projectId: $this->projectId,
            );

        }
        $this->removeFromDuplicates($paperId);
    }

    public function rejectDuplicate($paperId)
    {
        $paper = Papers::find($paperId);
        if ($paper) {
            $paper->update(['status_selection' => 3]); // Status 'Unclassified'
            $this->toast("Paper ID {$paperId} marked as unclassified.", 'info');
            // Log da atividade com o número de papers duplicados
            Log::logActivity(
                action: 'Paper have been successfully marked as unclassified',
                description: 'Papers unclassified confirmed. - '.$paperId,
                projectId: $this->projectId,
            );
        }
        $this->removeFromDuplicates($paperId);
    }

    private function removeFromDuplicates($paperId)
    {
        foreach ($this->duplicates as $title => $papers) {
            foreach ($papers as $index => $paper) {
                if ($paper->id_paper == $paperId) {
                    unset($this->duplicates[$title][$index]);
                }
            }

            if (empty($this->duplicates[$title])) {
                unset($this->duplicates[$title]);
            }
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
        return view('livewire.conducting.study-selection.buttons');
    }
}
