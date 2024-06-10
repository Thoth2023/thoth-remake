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
       
        $csvData = ''; 
        return response()->streamDownload(function() use ($csvData) {
            echo $csvData;
        }, 'studies.csv');
    }

    public function exportXml($projectId)
    {
        
        $xmlData = ''; 
        return response()->streamDownload(function() use ($xmlData) {
            echo $xmlData;
        }, 'studies.xml');
    }

    public function exportPdf($projectId)
    {
        
        $pdfData = ''; 
        return response()->streamDownload(function() use ($pdfData) {
            echo $pdfData;
        }, 'studies.pdf');
    }
}
