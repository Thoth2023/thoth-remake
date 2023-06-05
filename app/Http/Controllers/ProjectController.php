<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ProjectStoreRequest;
use App\Http\Requests\Project\ProjectAddMemberRequest;
use App\Http\Requests\Project\UpdateMemberLevelRequest;
use App\Models\Project;
use App\Models\Activity;
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
    public function store(ProjectStoreRequest $request)
    {
        $request->validated();
        $id_user = Auth::user()->id;
        $project = Project::create([
            'id_user' => $id_user,
            'title' => $request->title,
            'description' => $request->description,
            'objectives' => $request->objectives,
            //'copy_planning'
        ]);

        $project->users()->attach($project->id_project, ['id_user' => $id_user, 'level' => 1]);
        return redirect('/projects');
    }

    /**
     * Display the specified project.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);
        $users = $project->users;
        $activities = Activity::where('id_project', $id)->get();
        return view('projects.show', compact('project'), compact('users'), compact('activities'));
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

    /**
     * Remove a member from a project.
     * @param string $idProject The ID of the project.
     * @param mixed $idMember The ID of the member.
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function destroy_member(string $idProject, $idMember)
    {
        $project = Project::findOrFail($idProject);
        $project->users()->detach($idMember);
        return redirect()->back();
    }

    /**
     * Display the form to add a member to a project.
     * @param string $idProject The ID of the project.
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function add_member(string $idProject) 
    {
        $project = Project::findOrFail($idProject); 
        $users_relation = $project->users()->get(); 

        return view('projects.add_member', compact('project','users_relation')); 
    }
    
    /**
     * Add a member to a project based on the submitted form data.
     * @param \App\Http\Requests\ProjectAddMemberRequest $request The validated request object.
     * @param string $idProject The ID of the project.
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function add_member_project(ProjectAddMemberRequest $request, string $idProject)
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

    /**
     * Update the level of a project member.
     * @param \App\Http\Requests\UpdateMemberLevelRequest $request The validated request object.
     * @param mixed $idProject The ID of the project.
     * @param mixed $idMember The ID of the member.
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update_member_level(UpdateMemberLevelRequest $request, $idProject, $idMember)
    {
        $project = Project::findOrFail($idProject);
        $member = $project->users()->findOrFail($idMember);
        $validatedData = $request->validated();

        $member->pivot->level = $validatedData['level_member'];
        $member->pivot->save();

        return redirect()->back()->with('succes', 'The member level has been changed successfully.');
    }

    /**
     * Find the ID of a user based on their email.
     * @param string $email The email of the user.
     * @return mixed The ID of the user.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findIdByEmail($email)
    {
        $user = User::where('email', $email)->firstOrFail();
        $userId = $user->id;

        return $userId;
    }
}
