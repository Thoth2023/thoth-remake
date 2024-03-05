<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Database;
use App\Models\Domain;
use App\Models\Keyword;
use App\Models\Language;
use App\Models\Project;
use App\Models\ProjectDatabase;
use App\Models\ProjectLanguage;
use App\Models\ProjectStudyType;
use App\Models\StudyType;
use App\Utils\ActivityLogHelper;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PlanningOverallInformationController extends Controller
{
    /**
     * Display the initial page of the Overall Information about the Planning
     */
    public function index(string $id_project)
    {
        $project = Project::findOrFail($id_project);
        $usersRelation = $project->users()->get();
        $languages = Language::all();
        $databases = Database::all();
        $studyTypes = StudyType::all();
        $activeTab = 'overall-info';
        $projectLanguages = ProjectLanguage::where('id_project', $id_project)->get();
        $projectDatabases = ProjectDatabase::where('id_project', $id_project)->get();
        $projectStudyTypes = ProjectStudyType::where('id_project', $id_project)->get();
        $domains = Domain::where('id_project', $id_project)->get();
        $keywords = Keyword::where('id_project', $id_project)->get();
        return view('project.planning.index', compact('domains', 'id_project', 'project', 'languages', 'projectLanguages', 'databases', 'projectDatabases', 'studyTypes', 'projectStudyTypes', 'keywords', 'usersRelation'));
    }

    // DOMAIN AREA

    /**
     * Store a newly created Domain
     */
    public function domainUpdate(Request $request)
    {
        $activeTab = 'overall-info';
        $this->validate($request, [
            'description' => 'required|string',
        ]);

        $domain = Domain::create([
            'id_project' => $request->id_project,
            'description' => $request->description,
        ]);
        $id_project = $request->id_project;
        $activity = "Added the domain " . $domain->description;
        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);
        return redirect("/planning/" . $id_project);
    }

    /*
    * Update an existing Domain of the project
    */
    public function domainEdit(Request $request, string $id)
    {
        $activeTab = 'overall-info';
        $domain = Domain::findOrFail($id);
        $description_old = $domain->description;
        $domain->update($request->all());
        $id_project = $domain->id_project;
        $activity = "Edited the domain " . $description_old . " for " . $domain->description;
        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);

        return redirect("/planning/" . $id_project);
    }

    /*
    * Remove the specified Domain from the project
    */
    public function domainDestroy(string $id)
    {
        $activeTab = 'overall-info';
        $domain = Domain::findOrFail($id);
        $id_project = $domain->id_project;
        $domain->delete();
        $activity = "Deleted the domain " . $domain->description;
        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);

        return redirect("/planning/" . $id_project);
    }
    // DOMAIN AREA

    // DATABASE AREA
    /**
     * Add a Database stored in the database to the project
     */
    public function databaseAdd(Request $request)
    {
        $activeTab = 'overall-info';
        $this->validate($request, [
            'id_database' => 'required|string',
            'id_database' => 'required|string|unique:project_databases,id_database,NULL,id_project,id_project,' . $request->id_project,
        ]);

        ProjectDatabase::create([
            'id_project' => $request->id_project,
            'id_database' => $request->id_database,
        ]);
        $id_project = $request->id_project;

        return redirect("/planning/" . $id_project);
    }

    /*
    * Remove the specified Database from the project
    */
    public function databaseDestroy(string $id)
    {
        $activeTab = 'overall-info';
        $database = ProjectDatabase::where('id_database', $id)->first();
        $id_project = $database->id_project;
        $database->delete();

        return redirect("/planning/" . $id_project);
    }

    // LANGUAGE AREA

    /**
     * Add a language stored in the database to the project
     */
    public function languageAdd(Request $request)
    {
        $activeTab = 'overall-info';
        $this->validate($request, [
            'id_language' => 'required|string',
        ]);
        $matchThese = ['id_project' => $request->id_project, 'id_language' => $request->id_language];
        $language = ProjectLanguage::where($matchThese)->first();

        if ($language) {
            return back()->withErrors([
                'duplicate' => 'The provided language already exists in this project.',
            ]);
        } else {
            $project_language = ProjectLanguage::create([
                'id_project' => $request->id_project,
                'id_language' => $request->id_language,
            ]);

            $language = Language::findOrFail($project_language->id_language);
            $id_project = $request->id_project;

            $activity = "Added the language " . $language->description;
            ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);
            return redirect("/planning/" . $id_project);
        }
    }

    /*
    * Remove the specified Language from the project
    */
    public function languageDestroy(string $id)
    {
        $project_language = ProjectLanguage::where('id_language', $id)->first();
        $language = Language::findOrFail($project_language->id_language);
        $id_project = $project_language->id_project;
        $activeTab = 'overall-info';
        $project_language->delete();

        $activity = "Deleted the language " . $language->description;
        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);

        return redirect()->back();
    }
    // LANGUAGE AREA

    // STUDY TYPE AREA
    /**
     * Add a study type stored in the database to the project
     */
    public function studyTAdd(Request $request)
    {
        $activeTab = 'overall-info';
        $this->validate($request, [
            'id_study_type' => 'required|string',
        ]);
        $matchThese = ['id_project' => $request->id_project, 'id_study_type' => $request->id_study_type];
        $study_type = ProjectStudyType::where($matchThese)->first();

        if ($study_type) {
            return back()->withErrors([
                'duplicate' => 'The provided study type already exists in this project.',
            ]);
        } else {
            $project_study_type = ProjectStudyType::create([
                'id_project' => $request->id_project,
                'id_study_type' => $request->id_study_type,
            ]);
            $study_type = StudyType::findOrFail($project_study_type->id_study_type);

            $id_project = $request->id_project;

            $activity = "Added the study type " . $study_type->description;
            ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);
            return redirect("/planning/" . $id_project);
        }
    }

    /*
    * Remove the specified Study Type from the project
    */
    public function studyTDestroy(string $id)
    {
        $activeTab = 'overall-info';
        $project_studyT = ProjectStudyType::where('id_study_type', $id)->first();
        $id_project = $project_studyT->id_project;

        $studyT = StudyType::findOrFail($project_studyT->id_study_type);
        $activity = "Deleted the study type " . $studyT->description;

        $project_studyT->delete();

        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);
        return redirect("/planning/" . $id_project);
    }
    // STUDY TYPE AREA

    // KEYWORD AREA
    /**
     * Store a newly created Keyword
     */
    public function keywordAdd(Request $request)
    {
        $activeTab = 'overall-info';
        $this->validate($request, [
            'description' => 'required|string',
        ]);

        $keyword = Keyword::create([
            'id_project' => $request->id_project,
            'description' => $request->description,
        ]);
        $id_project = $keyword->id_project;

        $activity = "Added the keyword " . $keyword->description;
        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);
        return redirect("/planning/" . $id_project);
    }

    /*
    * Update an existing Keyword of the project
    */
    public function keywordEdit(Request $request, string $id)
    {
        $activeTab = 'overall-info';
        $keyword = Keyword::findOrFail($id);
        $keyword_old = $keyword->description;
        $keyword->update($request->all());
        $id_project = $keyword->id_project;

        $activity = "Edited the keyword " . $keyword_old . " for " . $keyword->description;
        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);
        return redirect("/planning/" . $id_project);
    }

    /*
    * Remove the specified Keyword from the project
    */
    public function keywordDestroy(string $id)
    {
        $activeTab = 'overall-info';
        $keyword = Keyword::findOrFail($id);
        $id_project = $keyword->id_project;
        $activity = "Deleted the keyword " . $keyword->description;
        $keyword->delete();
        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);

        return redirect("/planning/" . $id_project);
    }
    // DOMAIN AREA

    /**
     * Add date to a project.
     *
     * We get the start date and the end date from the form
     * and we add them to the project via the addDate method
     *
     * TODO: Separate the validation from the controller
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function addDate(Request $request, $projectId)
    {
        $activeTab = 'overall-info';
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Define the validation rules
        $rules = [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];

        // Create a custom error message for the date comparison
        $customMessages = [
            'end_date.after' => 'The end date must be after the start date.',
        ];

        // Validate the form input
        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $project = Project::findOrFail($projectId);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException('The project does not exist.');
        }

        $project->addDate($startDate, $endDate);
        $activity = "Added the start date " . $project->start_date . " and end date " . $project->end_date;
        ActivityLogHelper::insertActivityLog($activity, 1, $project->id_project, Auth::user()->id);


        return redirect()->route('project.planning.index', ['id' => $project->id_project, 'project' => $project]);
    }
}
