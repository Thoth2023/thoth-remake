<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ProjectAddMemberRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        $user = auth()->user();
        $projects_relation = $user->projects;

        $projects = Project::where('id_user', $user->id)->get();
        $merged_projects = $projects_relation->merge($projects);
        return view('projects.index', compact('merged_projects'));
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

    public function destroy_member(string $idProject, $idMember)
    {
        $project = Project::findOrFail($idProject);
        $project->users()->detach($idMember);
        return redirect()->back();
    }

    public function add_member(string $idProject) 
    {
        $project = Project::findOrFail($idProject); 
        $users_relation = $project->users()->get(); 

        return view('projects.add_member', compact('project','users_relation')); 
    }
    
    public function add_member_update(ProjectAddMemberRequest $request, string $idProject)
    {   
        $request->validated();
        $project = Project::findOrFail($idProject);
        $email_member = $request->get('email_member');
        $member_id = $this->findIdByEmail($email_member);
        $level_member = $request->get('level_member');

        $project->users()->attach($idProject, ['id_user' => $member_id, 'level' => $level_member]);

        $project->update($request->all());
        return redirect()->back();
    }

    public function findIdByEmail($email)
    {
        $user = User::where('email', $email)->firstOrFail();
        $userId = $user->id;

        return $userId;
    }
}
