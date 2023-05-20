<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' =>'required|string|max:255',
            'description' =>'required|string',
            'objectives' =>'required|string'
        ]);

        $id_user = Auth::user()->id;
        Project::create([
            'id_user' => $id_user,
            'title' => $request->title,
            'description' => $request->description,
            'objectives' => $request->objectives,
            //'copy_planning'
        ]);
        return redirect('/projects');
    }

    /**
     * Display the specified project.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(string $idProject)
    {
        $project = Project::findOrFail($idProject);
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());
        return redirect('/projects');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(string $id)
    {
         $project = Project::findOrFail($id);
         $project->delete();
         return redirect('/projects');
    }
}
