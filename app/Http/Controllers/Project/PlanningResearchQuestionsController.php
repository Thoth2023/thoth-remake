<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ResearchQuestion;
use App\Utils\ActivityLogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanningResearchQuestionsController extends Controller
{
    /**
     * Display the initial page of the Research Questions about the Planning
     */
    public function index(string $id_project)
    {
        $project = Project::findOrFail($id_project);
        $researchQuestions = ResearchQuestion::where('id_project', $id_project)->get();
        return view('project.planning.research_questions', compact('id_project', 'project', 'researchQuestions'));
    }

    /**
     * Store a newly created Research Question
     */
    public function add(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|string',
            'id' => 'required|alpha_num',
        ]);
        $matchThese = ['id_project' => $request->id_project, 'id' => $request->id];
        $researchQuestion = ResearchQuestion::where($matchThese)->first();

        if ($researchQuestion) {
            return back()->withErrors([
                'duplicate' => 'The provided ID already exists in this project.',
            ]);
        } else {
            $research_question = ResearchQuestion::create([
                'id_project' => $request->id_project,
                'id' => $request->id,
                'description' => $request->description,
            ]);

            $id_project = $request->id_project;

            $activity = "Added the research question " . $research_question->id;
            ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);

            return redirect("/planning/" . $id_project);
        }
    }

    /*
    * Update an existing Research Question of the project
    */
    public function edit(Request $request, string $id)
    {

        $this->validate($request, [
            'description' => 'required|string',
            'id' => 'required|alpha_num',
        ]);

        $researchQuestion = ResearchQuestion::findOrFail($id);
        $matchThese = ['id_project' => $request->id_project, 'id' => $request->id];
        $researchQuestion2 = ResearchQuestion::where($matchThese)->first();

        if ($researchQuestion2) {
            return back()->withErrors([
                'duplicate' => 'The provided ID already exists in this project.',
            ]);
        } else {
            $researchQuestion->update($request->all());
        }
        $id_project = $researchQuestion->id_project;

        $activity = "Edited the research question " . $researchQuestion->id;
        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);

        $activity = "Edited the research question " . $researchQuestion->id;
        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);

        return redirect("/planning/" . $id_project);

    }

    /*
    * Remove the specified Research Question from the project
    */
    public function destroy(string $id)
    {
        $researchQuestion = ResearchQuestion::findOrFail($id);
        $id_project = $researchQuestion->id_project;

        $activity = "Deleted the research question " . $researchQuestion->id;

        $researchQuestion->delete();

        ActivityLogHelper::insertActivityLog($activity, 1, $id_project, Auth::user()->id);

        return redirect("/planning/" . $id_project);
    }
}
