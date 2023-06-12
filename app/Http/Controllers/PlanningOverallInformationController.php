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
        $studyTypes = StudyType::all();
        $projectLanguages = ProjectLanguage::where('id_project', $id_project)->get();
        $projectStudyTypes = ProjectStudyType::where('id_project', $id_project)->get();
        $domains = Domain::where('id_project', $id_project)->get();
        $keywords = Keyword::where('id_project', $id_project)->get();
        return view('planning.index', compact('domains', 'id_project', 'project','languages', 'projectLanguages', 'studyTypes', 'projectStudyTypes', 'keywords', 'usersRelation'));
    }

    // DOMAIN AREA
    /**
     * Store a newly created Domain
     */
    public function domainUpdate(Request $request)
    {
        $this->validate($request, [
            'description' =>'required|string',
        ]);

        Domain::create([
            'id_project' => $request->id_project,
            'description' => $request->description,
        ]);
        $id_project = $request->id_project;

        return redirect("/planning/".$id_project);
    }

    /*
    * Update an existing Domain of the project
    */
    public function domainEdit(Request $request, string $id)
    {
        $domain = Domain::findOrFail($id);
        $domain->update($request->all());
        $id_project = $domain->id_project;

        return redirect("/planning/".$id_project);
    }

    /*
    * Remove the specified Domain from the project
    */
    public function domainDestroy(string $id)
    {
         $domain = Domain::findOrFail($id);
         $id_project = $domain->id_project;
         $domain->delete();

         return redirect("/planning/".$id_project);
    }
    // DOMAIN AREA

    // LANGUAGE AREA
    /**
     * Add a language stored in the database to the project
     */
    public function languageAdd(Request $request)
    {
        $this->validate($request, [
            'id_language' =>'required|string',
        ]);

        ProjectLanguage::create([
            'id_project' => $request->id_project,
            'id_language' => $request->id_language,
        ]);
        $id_project = $request->id_project;

        return redirect("/planning/".$id_project);
    }

    /*
    * Remove the specified Language from the project
    */
    public function languageDestroy(string $id)
    {

         $language = ProjectLanguage::where('id_language', $id)->first();
         $id_project = $language->id_project;
         $language->delete();

         return redirect("/planning/".$id_project);
    }
    // LANGUAGE AREA

    // STUDY TYPE AREA
    /**
     * Add a study type stored in the database to the project
     */
    public function studyTAdd(Request $request)
    {
        $this->validate($request, [
            'id_study_type' =>'required|string',
        ]);

        ProjectStudyType::create([
            'id_project' => $request->id_project,
            'id_study_type' => $request->id_study_type,
        ]);
        $id_project = $request->id_project;

        return redirect("/planning/".$id_project);
    }

    /*
    * Remove the specified Study Type from the project
    */
    public function studyTDestroy(string $id)
    {

         $studyT = ProjectStudyType::where('id_study_type', $id)->first();
         $id_project = $studyT->id_project;
         $studyT->delete();

         return redirect("/planning/".$id_project);
    }
    // STUDY TYPE AREA

    // KEYWORD AREA
    /**
     * Store a newly created Keyword
     */
    public function keywordAdd(Request $request)
    {
        $this->validate($request, [
            'description' =>'required|string',
        ]);

        Keyword::create([
            'id_project' => $request->id_project,
            'description' => $request->description,
        ]);
        $id_project = $request->id_project;

        return redirect("/planning/".$id_project);
    }

    /*
    * Update an existing Keyword of the project
    */
    public function keywordEdit(Request $request, string $id)
    {
        $keyword = Keyword::findOrFail($id);
        $keyword->update($request->all());
        $id_project = $keyword->id_project;

        return redirect("/planning/".$id_project);
    }

    /*
    * Remove the specified Keyword from the project
    */
    public function keywordDestroy(string $id)
    {
         $keyword = Keyword::findOrFail($id);
         $id_project = $keyword->id_project;
         $keyword->delete();

         return redirect("/planning/".$id_project);
    }
    // DOMAIN AREA
}
