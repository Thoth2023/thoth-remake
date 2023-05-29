<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\ResearchQuestion;

class PlanningResearchQuestionsController extends Controller
{
    /**
     * Display the initial page of the Research Questions about the Planning
     */
    public function index(string $id_project)
    {
        $project = Project::findOrFail($id_project);
        $researchQuestions = ResearchQuestion::where('id_project', $id_project)->get();
        return view('planning.research_questions', compact('id_project', 'project', 'researchQuestions'));
    }

     /**
     * Store a newly created Research Question
     */
    public function add(Request $request)
    {
        $this->validate($request, [
            'description' =>'required|string',
            'id' => 'required|alpha_num',
        ]);

        $researchQuestion = ResearchQuestion::where('id_project', $request->id_project && 'id', $request->id)->get();
        if($researchQuestion){
            return back();
        }

        ResearchQuestion::create([
            'id_project' => $request->id_project,
            'id' => $request->id,
            'description' => $request->description,
        ]);

        $id_project = $request->id_project;

        return redirect("/planning/".$id_project."/research_questions");
    }

    /*
    * Update an existing Research Question of the project
    */
    public function edit(Request $request, string $id)
    {

        $this->validate($request, [
            'description' =>'required|string',
            'id' => 'required|alpha_num',
        ]);

        $researchQuestion = ResearchQuestion::findOrFail($id);
        $researchQuestion->update($request->all());
        $id_project = $researchQuestion->id_project;

        return redirect("/planning/".$id_project."/research_questions");
        
    }

    /*
    * Remove the specified Research Question from the project
    */
    public function destroy(string $id)
    {
         $researchQuestion = ResearchQuestion::findOrFail($id);
         $id_project = $researchQuestion->id_project;
         $researchQuestion->delete();

         return redirect("/planning/".$id_project."/research_questions");
    }
}
