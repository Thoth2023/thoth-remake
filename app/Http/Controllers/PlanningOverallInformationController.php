<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Domain;
use App\Models\Language;
use App\Models\ProjectLanguage;
use App\Models\StudyType;
use App\Models\ProjectStudyType;
use App\Models\Keyword;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PlanningOverallInformationController extends Controller
{
    /**
     * Display the initial page of the Overall Information about the Planning
     */
    public function index(string $id_project)
    {
        $project = Project::findOrFail($id_project);
        $languages = Language::all();
        $studyTypes = StudyType::all();
        $projectLanguages = ProjectLanguage::where('id_project', $id_project)->get();
        $projectStudyTypes = ProjectStudyType::where('id_project', $id_project)->get();
        $domains = Domain::where('id_project', $id_project)->get();
        $keywords = Keyword::where('id_project', $id_project)->get();
        return view('planning.index')
            ->with('id_project', $id_project)
            ->with('domains', $domains)
            ->with('project', $project)
            ->with('languages', $languages)
            ->with('projectLanguages', $projectLanguages)
            ->with('studyTypes', $studyTypes)
            ->with('projectStudyTypes', $projectStudyTypes)
            ->with('keywords', $keywords);
    }

    // DOMAIN AREA
    /**
     * Store a newly created Domain
     */
    public function domainUpdate(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|string',
        ]);

        Domain::create([
            'id_project' => $request->id_project,
            'description' => $request->description,
        ]);
        $id_project = $request->id_project;

        return redirect("/planning/" . $id_project);
    }

    /*
    * Update an existing Domain of the project
    */
    public function domainEdit(Request $request, string $id)
    {
        $domain = Domain::findOrFail($id);
        $domain->update($request->all());
        $id_project = $domain->id_project;

        return redirect("/planning/" . $id_project);
    }

    /*
    * Remove the specified Domain from the project
    */
    public function domainDestroy(string $id)
    {
        $domain = Domain::findOrFail($id);
        $id_project = $domain->id_project;
        $domain->delete();

        return redirect("/planning/" . $id_project);
    }
    // DOMAIN AREA

    // LANGUAGE AREA
    /**
     * Add a language stored in the database to the project
     */
    public function languageAdd(Request $request)
    {
        $this->validate($request, [
            'id_language' => 'required|string',
        ]);

        ProjectLanguage::create([
            'id_project' => $request->id_project,
            'id_language' => $request->id_language,
        ]);
        $id_project = $request->id_project;

        return redirect("/planning/" . $id_project);
    }

    /*
    * Remove the specified Language from the project
    */
    public function languageDestroy(string $id)
    {

        $language = ProjectLanguage::where('id_language', $id)->first();
        $id_project = $language->id_project;
        $language->delete();

        return redirect("/planning/" . $id_project);
    }
    // LANGUAGE AREA

    // STUDY TYPE AREA
    /**
     * Add a study type stored in the database to the project
     */
    public function studyTAdd(Request $request)
    {
        $this->validate($request, [
            'id_study_type' => 'required|string',
        ]);

        ProjectStudyType::create([
            'id_project' => $request->id_project,
            'id_study_type' => $request->id_study_type,
        ]);
        $id_project = $request->id_project;

        return redirect("/planning/" . $id_project);
    }

    /*
    * Remove the specified Study Type from the project
    */
    public function studyTDestroy(string $id)
    {

        $studyT = ProjectStudyType::where('id_study_type', $id)->first();
        $id_project = $studyT->id_project;
        $studyT->delete();

        return redirect("/planning/" . $id_project);
    }
    // STUDY TYPE AREA

    // KEYWORD AREA
    /**
     * Store a newly created Keyword
     */
    public function keywordAdd(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|string',
        ]);

        Keyword::create([
            'id_project' => $request->id_project,
            'description' => $request->description,
        ]);
        $id_project = $request->id_project;

        return redirect("/planning/" . $id_project);
    }

    /*
    * Update an existing Keyword of the project
    */
    public function keywordEdit(Request $request, string $id)
    {
        $keyword = Keyword::findOrFail($id);
        $keyword->update($request->all());
        $id_project = $keyword->id_project;

        return redirect("/planning/" . $id_project);
    }

    /*
    * Remove the specified Keyword from the project
    */
    public function keywordDestroy(string $id)
    {
        $keyword = Keyword::findOrFail($id);
        $id_project = $keyword->id_project;
        $keyword->delete();

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addDate(Request $request, $projectId)
    {
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

        return redirect()->route('planning.index', ['id' => $project->id_project, 'project' => $project]);
    }
}
