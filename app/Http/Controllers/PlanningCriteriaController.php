<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Criteria;

class PlanningCriteriaController extends Controller
{
    /**
     * Display the initial page of the Criteria about the Planning
     */
    public function index(string $id_project)
    {
        $project = Project::findOrFail($id_project);
        $inclusions = ['id_project' => $id_project, 'type' => 'Inclusion'];
        $exclusions = ['id_project' => $id_project, 'type' => 'Exclusion'];
        $inclusion_criterias = Criteria::where($inclusions)->get();
        $exclusion_criterias = Criteria::where($exclusions)->get();
        return view('planning.criteria', compact('id_project', 'project', 'inclusion_criterias', 'exclusion_criterias'));
    }

     /**
     * Store a newly created Criteria
     */
    public function add(Request $request)
    {
        $this->validate($request, [
            'description' =>'required|string',
            'id' => 'required|alpha_num',
            'pre_selected' => 'required|alpha_num',
            'type' => 'required|string',
        ]);
        $matchThese = ['id_project' => $request->id_project, 'id' => $request->id];
        $criteria = Criteria::where($matchThese)->first();

        if($criteria){
            return back()->withErrors([
                'duplicate' => 'The provided ID already exists in this project.',
            ]);;
        }
        else{
            Criteria::create([
                'id_project' => $request->id_project,
                'id' => $request->id,
                'description' => $request->description,
                'type' => $request->type,
                'pre_selected' => $request->pre_selected,
            ]);

            $id_project = $request->id_project;

            return redirect("/planning/".$id_project);
        }
    }

    /*
    * Update an existing Criteria of the project
    */
    public function edit(Request $request, string $id)
    {

        $this->validate($request, [
            'description' =>'required|string',
            'id' => 'required|alpha_num',
            'pre_selected' => 'required|int',
            'type' => 'required|string',
        ]);

        $criteria = Criteria::findOrFail($id);
        $matchThese = ['id_project' =>$request->id_project, 'id' =>$request->id];
        $criteria2 = Criteria::where($matchThese)->first();

        if($criteria2){
            return back()->withErrors([
                'duplicate' => 'The provided ID already exists in this project.',
            ]);
        }
        else{
            $criteria->update($request->all());
        }
        $id_project = $criteria->id_project;

        return redirect("/planning/".$id_project);

    }

    /*
    * Remove the specified Criteria from the project
    */
    public function destroy(string $id)
    {
         $criteria = Criteria::findOrFail($id);
         $id_project = $criteria->id_project;
         $criteria->delete();

         return redirect("/planning/".$id_project);
    }

    /*
    * Change pre selected value of a criteria
    */
    public function change_preselected(Request $request, string $id)
    {
        $this->validate($request, [
            'pre_selected' => 'required|int',
        ]);

        $criteria = Criteria::findOrFail($id);

        $criteria->update($request->all());

        $id_project = $criteria->id_project;

        return redirect("/planning/".$id_project);
    }
}
