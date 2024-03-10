<?php

namespace App\Http\Controllers\Project\Planning;

use App\Models\Project;
use App\Models\Domain;
use App\Models\Keyword;
use App\Models\Database;
use App\Models\Language;
use App\Models\StudyType;
use App\Http\Controllers\Controller;

class OverallController extends Controller
{

    /**
     * Display the initial page of the Overall Information about the Planning
     */
    public function index(string $id_project)
    {
        // Retrieve the project or throw a ModelNotFoundException
        $project = Project::findOrFail($id_project);

        // Eager load users relation for better performance
        $usersRelation = $project->users()->get();

        // Set the active tab
        $activeTab = 'overall-info';

        $databases = Database::all();
        $languages = Language::all();
        $studyTypes = StudyType::all();

        // Retrieve project-specific language, database, study type, domains and keywords records
        $projectDomains = Domain::where('id_project', $id_project)->get();
        $projectKeywords = Keyword::where('id_project', $id_project)->get();

        // Compact and pass variables to the view
        return view('project.planning.index', compact(
            'id_project',
            'project',
            'projectDomains',
            'projectKeywords',
            'databases',
            'languages',
            'studyTypes',
            'usersRelation',
            'activeTab'
        ));
    }
}
