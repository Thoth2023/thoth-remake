<?php

namespace App\Http\Controllers\Project\Conducting;

use App\Http\Controllers\Controller;
use App\Models\Project\Conducting\Papers;
use App\Models\Project\Conducting\StudySelection;
use Illuminate\Http\Request;

class StudySelectionController extends Controller
{   

    public function index($projectId) {
        $papers = Papers::where('project_id', $projectId)->get();
        
        return view('project.conducting.study-selection.index', compact('papers', 'projectId'));
    }
    
}
