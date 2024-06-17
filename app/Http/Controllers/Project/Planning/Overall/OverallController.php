<?php

namespace App\Http\Controllers\Project\Planning\Overall;

use App\Http\Controllers\Controller;
use App\Models\Database;
use App\Models\Domain;
use App\Models\Keyword;
use App\Models\Language;
use App\Models\Project;
use App\Models\Project\Planning\DataExtraction\QuestionTypes;
use App\Models\StudyType;

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

        $databases = Database::all();
        $languages = Language::all();
        $studyTypes = StudyType::all();
        $questionTypes = QuestionTypes::all();

        // Retrieve project-specific language, database, study type, domains and keywords records
        $projectDomains = Domain::where('id_project', $id_project)->get();
        $projectKeywords = Keyword::where('id_project', $id_project)->get();

        // Retrieve search-string
        $terms = $project->terms;
        $synonyms = $project->synonyms;
        $searchStrings = []; // simulating the search string results

        return view(
            'project.planning.index',
            compact(
                'id_project',
                'project',
                'projectDomains',
                'projectKeywords',
                'databases',
                'languages',
                'studyTypes',
                'questionTypes',
                'usersRelation',
                'terms',
                'synonyms',
                'searchStrings',
            )
        );
    }
}
