<?php

namespace App\Livewire\Conducting\StudySelection;

use App\Models\BibUpload;
use App\Models\Project\Conducting\Papers;
use App\Models\ProjectDatabases;
use Livewire\Component;
use TCPDF;

class Buttons extends Component
{   

    public $projectId;

    public function removeDuplicates()
    {
        $papers = $this->getPapers($this->projectId);
        $uniquePapers = [];
        $titles = [];

        foreach ($papers as $paper) {
            if (!in_array($paper->title, $titles)) {
                $uniquePapers[] = $paper;
                $titles[] = $paper->title;
            }
        }

        foreach ($papers as $paper) {
            if (!in_array($paper, $uniquePapers)) {
                $paper->delete();
            }
        }

        return redirect()->route('conducting.study-selection', $this->projectId);
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
