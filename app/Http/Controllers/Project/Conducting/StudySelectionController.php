<?php

namespace App\Http\Controllers\Project\Conducting;

use App\Http\Controllers\Controller;
use App\Models\BibUpload;
use App\Models\Project;
use App\Models\Project\Conducting\Papers;
use App\Models\Project\Conducting\StudySelection;
use App\Models\ProjectDatabases;
use Illuminate\Http\Request;

class StudySelectionController extends Controller
{   

    public function index($projectId) {

        $currentProject = Project::findOrFail($projectId);

        $idsDatabase = ProjectDatabases::where('id_project', $projectId)->pluck('id_project_database');

        $idsBib = [];

        if (count($idsDatabase) > 0) {
            $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();
        }

        $papers = Papers::whereIn('id_bib', $idsBib)->get();
        
        return view('project.conducting.study-selection.index', compact('papers'));
    }
    
    public function exportCsv($projectId)
    {
        $papers = $this->getPapers($projectId);
        $csvData = $this->formatCsv($papers);
        return response()->streamDownload(function() use ($csvData) {
            echo $csvData;
        }, 'studies.csv');
    }

    public function exportXml($projectId)
    {
        $papers = $this->getPapers($projectId);
        $xmlData = $this->formatXml($papers); 
        return response()->streamDownload(function() use ($xmlData) {
            echo $xmlData;
        }, 'studies.xml');
    }

    public function exportPdf($projectId)
    {
        
        $papers = $this->getPapers($projectId);
        $pdfData = $this->formatPdf($papers); 
        return response()->streamDownload(function() use ($pdfData) {
            echo $pdfData;
        }, 'studies.pdf');
    }

    private function getPapers($projectId)
    {
        $idsDatabase = ProjectDatabases::where('id_project', $projectId)->pluck('id_project_database');

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
            $database = $paper->database->name ?? '';
            $status = $paper->status->description ?? '';

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
            $paperElement->addChild('status', $paper->status->description ?? '');
        
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
}
