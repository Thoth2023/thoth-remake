<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domain;

class PlanningOverallInformationController extends Controller
{
    /**
     * Display the initial page of the Overall Information about the Planning
     */
    public function index(string $id_project)
    {
        $domains = Domain::where('id_project', $id_project)->get();
        return view('planning.index', compact('domains', 'id_project'));
    }
    /**
     * Display a list of the Domains of the project
     */
    public function domainList(string $id)
    {
        $domains = Domain::where('id_project', $id)->get();
        return view('projects.planning.index', compact('domains'));
    }

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
}
