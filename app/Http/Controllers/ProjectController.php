<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ProjectStoreRequest;
use App\Http\Requests\Project\ProjectUpdateRequest;
use App\Http\Requests\Project\ProjectAddMemberRequest;
use App\Http\Requests\Project\UpdateMemberLevelRequest;
use App\Livewire\Planning\Overall\Domains;
use App\Models\Project;
use App\Models\Activity;
use App\Models\User;
use App\Utils\ActivityLogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use App\Notifications\ProjectInvitationNotification;
use Illuminate\Support\Facades\Notification;

use PHPUnit\Event\Application\FinishedSubscriber;


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
     * Show the form for creating a new project.
     */
    public function create()
    {
        $userProjects = Auth::user()->projects;
        return view('projects.create', ['projects' => $userProjects]);
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
            'feature_review' => $request->feature_review
            //'copy_planning'
        ]);


        if ($request->copy_planning !== 'none') {
            $sourceProject = Project::findOrFail($request->copy_planning);
            $project->copyPlanningFrom($sourceProject);
        } else {
            $project->save();
        }

        $activity = "Created the project ".$project->title;
        ActivityLogHelper::insertActivityLog($activity, 1, $project->id_project, $user->id);

        $project->users()->attach($project->id_project, ['id_user' => $user->id, 'level' => 1]);

        return redirect('/projects');
    }

    /**
     * Display the specified project.
     */
    public function show(string $idProject)
    {
        $project = Project::findOrFail($idProject);

        // Verificar se o usuário tem permissão para acessar o projeto
        if (Gate::denies('access-project', $project)) {
            return redirect('/projects')->with('error', 'Você não tem permissão para acessar este projeto.');
        }

        // Obter relação de usuários e atividades caso a permissão seja concedida
        $users_relation = $project->users()->get();
        $activities = Activity::where('id_project', $idProject)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('projects.show', compact('project', 'users_relation', 'activities'));
    }


    /**
     * Show the form for editing the specified project.
     */
    public function edit(string $idProject)
    {
        $userProjects = Auth::user()->projects;
        $project = Project::findOrFail($idProject);
        $user = Auth::user();

        if (!$project->userHasLevel($user, '1')) {
            return redirect()->back()->with('error', 'You do not have permission to edit the project.');
        }

        return view('projects.edit', compact('project'), ['projects' => $userProjects]);
    }

    /**
     * Update the specified project in storage.
     */
    public function update(ProjectUpdateRequest $request, string $id)
    {
        $request->validated();
        $project = Project::findOrFail($id);
        $user = Auth::user();

        if (!$project->userHasLevel($user, '1')) {
            return redirect()->back()->with('error', 'You do not have permission to edit the project.');
        }

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'objectives' => $request->objectives,
        ]);

        if ($request->copy_planning !== 'none') {
            $sourceProject = Project::findOrFail($request->copy_planning);
            $project->copyPlanningFrom($sourceProject);
        }

        $activity = "Edited project";
        ActivityLogHelper::insertActivityLog($activity, 1, $project->id_project, $user->id);

        return redirect('/projects');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $activity = "Deleted project ".$project->id_;
        $user = Auth::user();

        if (!$project->userHasLevel($user, '1')) {
            return redirect()->back()->with('error', 'You do not have permission to delete the project.');
        }

        $project->delete();
        ActivityLogHelper::insertActivityLog($activity, 1, null, $user->id);

        return redirect('/projects');
    }

    /**
     * Remove a member from a project.
     *
     * @param string $idProject The ID of the project.
     * @param mixed $idMember The ID of the member.
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function destroy_member(string $idProject, $idMember)
    {
        $project = Project::findOrFail($idProject);
        $project->users()->detach($idMember);
        $name_member = User::findOrFail($idMember);
        $user = Auth::user();

        if (!$project->userHasLevel($user, '1')) {
            return redirect()->back()->with('error', 'You do not have permission to remove a member from the project.');
        }

        $activity = "The admin removed the member ".$name_member->username." from ".$project->title.".";
        ActivityLogHelper::insertActivityLog($activity, 1, $project->id_project, $user->id);
        return redirect()->back();
    }

    /**
     * Display the form to add a member to a project.
     *
     * @param string $idProject The ID of the project.
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function add_member(string $idProject)
    {
        $project = Project::findOrFail($idProject);
        $users_relation = $project->users()->get();
        $user = Auth::user();

        if (!$project->userHasLevel($user, '1')) {
            return redirect()->back()->with('error', 'You do not have permission to add a member to the project.');
        }

        return view('projects.add_member', compact('project', 'users_relation'));
    }

    /**
 * Add a member to a project based on the submitted form data.
 *
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
    $name_member = User::findOrFail($member_id);
    $level_member = $request->get('level_member', 1);  // Default to level 1 if not specified

    $user = Auth::user();

    if ($project->users()->wherePivot('id_user', $member_id)->exists()) {
        return redirect()->back()->with('error', 'The user is already associated with the project.');
    }

    if (!$project->userHasLevel($user, '1')) {
        return redirect()->back()->with('error', 'You do not have permission to add a member to the project.');
    }

    $token = Str::random(40); // Generate a unique token
    $project->users()->attach($member_id, [
        'level' => $level_member,
        'invitation_token' => $token,
        'status' => 'pending'
    ]);

    Notification::send($name_member, new ProjectInvitationNotification($project, $token));

    $activity = "Sent invitation to " . $name_member->username . " to join the project " . $project->title;
    ActivityLogHelper::insertActivityLog($activity, 1, $project->id, $user->id);

    return redirect()->back()->with('success', 'Invitation sent to ' . $name_member->email);
}




    /**
     * Update the level of a project member.
     *
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
        $name_member = User::findOrFail($idMember);
        $user = Auth::user();

        if (!$project->userHasLevel($user, '1')) {
            return redirect()->back()->with('error', 'You do not have permission to update the member level.');
        }

        $member->pivot->level = $validatedData['level_member'];
        $member->pivot->save();

        $activity = "The admin updated ".$name_member->username." level to ".$validatedData['level_member'].".";
        ActivityLogHelper::insertActivityLog($activity, 1, $project->id_project, $user->id);

        return redirect()->back()->with('succes', 'The member level has been changed successfully.');
    }

    /**
     * Find the ID of a user based on their email.
     *
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


    public function acceptInvitation($idProject, Request $request)
    {
        $token = $request->query('token');

        // Busca o registro na tabela 'members'
        $invitation = DB::table('members')
                        ->where('invitation_token', $token)
                        ->where('id_project', $idProject)
                        ->first();

        if (!$invitation) {
            return back()->with('error', 'Invalid or expired invitation.');
        }

        // Atualiza o status do convite para 'accepted'
        DB::table('members')
            ->where('invitation_token', $token)
            ->where('id_project', $idProject)
            ->update([
                'status' => 'accepted',
                'invitation_token' => null  // Remove o token após ser aceito
            ]);

        $activity = "Accepted invitation to join the project.";
        ActivityLogHelper::insertActivityLog($activity, 1, $idProject, $invitation->id_user);

        return redirect('/projects')->with('success', 'You have successfully joined the project!');
    }


}
