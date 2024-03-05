<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectAddMemberRequest;
use App\Http\Requests\Project\ProjectStoreRequest;
use App\Http\Requests\Project\UpdateMemberLevelRequest;
use App\Models\Activity;
use App\Models\Project;
use App\Models\User;
use App\Utils\ActivityLogHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        foreach ($merged_projects as $project) {
            $project->setUserLevel($user);
        }

        return view('projects.index', compact('merged_projects'));
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(ProjectStoreRequest $request)
    {
        $request->validated();
        $user = Auth::user();
        $project = Project::create([
            'id_user' => $user->id,
            'title' => $request->title,
            'description' => $request->description,
            'objectives' => $request->objectives,
            'created_by' => $user->username,
            //'copy_planning'
        ]);

        $activity = "Created the project " . $project->title;
        ActivityLogHelper::insertActivityLog($activity, 1, $project->id_project, $user->id);

        $project->users()->attach($project->id_project, ['id_user' => $user->id, 'level' => 1]);

        return redirect('/projects');
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Display the specified project.
     */
    public function show(string $idProject)
    {
        $project = Project::findOrFail($idProject);
        $users_relation = $project->users()->get();
        $activities = Activity::where('id_project', $idProject)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('projects.show', compact('project'), compact('users_relation'))->with('activities', $activities);
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
     * Remove the specified project from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $activity = "Deleted project " . $project->id_;
        $project->delete();
        ActivityLogHelper::insertActivityLog($activity, 1, null, Auth::user()->id);

        return redirect('/projects');
    }

    /**
     * Remove a member from a project.
     * @param string $idProject The ID of the project.
     * @param mixed $idMember The ID of the member.
     * @return RedirectResponse
     * @throws ModelNotFoundException
     */
    public function destroy_member(string $idProject, $idMember)
    {
        $project = Project::findOrFail($idProject);
        $project->users()->detach($idMember);
        $name_member = User::findOrFail($idMember);

        $activity = "The admin removed the member " . $name_member->username . " from " . $project->title . ".";
        ActivityLogHelper::insertActivityLog($activity, 1, $project->id_project, Auth::user()->id);
        return redirect()->back();
    }

    /**
     * Display the form to add a member to a project.
     * @param string $idProject The ID of the project.
     * @return View
     * @throws ModelNotFoundException
     */
    public function add_member(string $idProject)
    {
        $project = Project::findOrFail($idProject);
        $users_relation = $project->users()->get();

        return view('projects.add_member', compact('project', 'users_relation'));
    }

    /**
     * Add a member to a project based on the submitted form data.
     * @param \App\Http\Requests\ProjectAddMemberRequest $request The validated request object.
     * @param string $idProject The ID of the project.
     * @return RedirectResponse
     * @throws ModelNotFoundException
     */
    public function add_member_project(ProjectAddMemberRequest $request, string $idProject)
    {
        $request->validated();
        $project = Project::findOrFail($idProject);
        $email_member = $request->get('email_member');
        $member_id = $this->findIdByEmail($email_member);
        $name_member = User::findOrFail($member_id);
        $level_member = $request->get('level_member');

        if ($project->users()->wherePivot('id_user', $member_id)->exists()) {
            return redirect()->back()->with('error', 'The user is already associated with the project.');
        }

        $project->users()->attach($idProject, ['id_user' => $member_id, 'level' => $level_member]);

        $activity = "Added a new member: " . $name_member->username;
        ActivityLogHelper::insertActivityLog($activity, 1, $project->id_project, Auth::user()->id);

        $project->update($request->all());
        return redirect()->back()->with('succes', $name_member->username . ' has been added to the current project.');
    }

    /**
     * Find the ID of a user based on their email.
     * @param string $email The email of the user.
     * @return mixed The ID of the user.
     * @throws ModelNotFoundException
     */
    public function findIdByEmail($email)
    {
        $user = User::where('email', $email)->firstOrFail();
        $userId = $user->id;

        return $userId;
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());

        $activity = "Edited project";
        ActivityLogHelper::insertActivityLog($activity, 1, $project->id_project, Auth::user()->id);

        return redirect('/projects');
    }

    /**
     * Update the level of a project member.
     * @param \App\Http\Requests\UpdateMemberLevelRequest $request The validated request object.
     * @param mixed $idProject The ID of the project.
     * @param mixed $idMember The ID of the member.
     * @return RedirectResponse
     * @throws ModelNotFoundException
     */
    public function update_member_level(UpdateMemberLevelRequest $request, $idProject, $idMember)
    {
        $project = Project::findOrFail($idProject);
        $member = $project->users()->findOrFail($idMember);
        $validatedData = $request->validated();
        $name_member = User::findOrFail($idMember);

        $member->pivot->level = $validatedData['level_member'];
        $member->pivot->save();

        $activity = "The admin updated " . $name_member->username . " level to " . $validatedData['level_member'] . ".";
        ActivityLogHelper::insertActivityLog($activity, 1, $project->id_project, Auth::user()->id);

        return redirect()->back()->with('succes', 'The member level has been changed successfully.');
    }
}
