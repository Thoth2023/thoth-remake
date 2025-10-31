<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\ProjectStoreRequest;
use App\Http\Requests\Project\ProjectUpdateRequest;
use App\Http\Requests\Project\ProjectAddMemberRequest;
use App\Http\Requests\Project\UpdateMemberLevelRequest;
use App\Livewire\Planning\Overall\Domains;
use App\Models\Project;
use App\Models\Activity;
use App\Models\ProjectNotification;
use App\Models\User;
use App\Utils\ActivityLogHelper;
use App\Http\Controllers\Project\Planning\PlanningProgressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Notifications\ProjectInvitationNotification;
use Illuminate\Support\Facades\Notification;

use PHPUnit\Event\Application\FinishedSubscriber;

use App\Services\ConductingProgressService;


class ProjectController extends Controller
{
    private PlanningProgressController $progressCalculator;
    private ConductingProgressService $conductingProgress;

    public function __construct(
        PlanningProgressController $progressCalculator,
        ConductingProgressService $conductingProgress
    ) {
        $this->progressCalculator = $progressCalculator;
        $this->conductingProgress = $conductingProgress;
    }

    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        $user = auth()->user();
        $all_projects = $user->projects;

        $projects_relation = $all_projects->filter(function($project) {
            $pivotStatus = $project->pivot->status ?? null;
            return $pivotStatus === 'accepted' || $pivotStatus === null;
        });

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
            'feature_review' => $request->feature_review,
            'is_public' => $request->has('is_public')
        ]);


        if ($request->copy_planning !== 'none') {
            $sourceProject = Project::findOrFail($request->copy_planning);
            $project->copyPlanningFrom($sourceProject);
        } else {
            $project->save();
        }

        $activity = __("project/projects.activity_created", ['title' => $project->title]);
        ActivityLogHelper::insertActivityLog($activity, 1, $project->id_project, $user->id);

       $project->users()->attach($project->id_project, ['id_user' => $user->id, 'level' => 1, 'status' => 'accepted']);

        return redirect('/projects');
    }

    /**
     * Display the specified project.
     */
    public function show(string $idProject)
    {
        $project = Project::findOrFail($idProject);

        if (Gate::denies('access-project', $project)) {
            return redirect('/projects')->with('error', __('project/projects.no_access_project'));
        }

        $users_relation = $project->users()->get();
        $activities = Activity::where('id_project', $idProject)
            ->orderBy('created_at', 'DESC')
            ->get();

        $timings = [];

        // Calcular o progresso do planejamento
        $planningProgress = $this->progressCalculator->calculate($idProject);

        // 2) Conducting progress
        $t1 = microtime(true);
        try {
            $conductingProgress = $this->conductingProgress->calculateProgress($idProject);
        } catch (\Throwable $e) {
            Log::error('conductingProgress error', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $conductingProgress = [];
        }
        $timings['conducting_ms'] = (int) round((microtime(true) - $t1) * 1000);

        //  garantir que planning entre no mesmo array
        $conductingProgress['planning'] = $planningProgress;

        //  também garantir que 'overall' existe
        if (!isset($conductingProgress['overall'])) {
            $conductingProgress['overall'] = 0;
        }

        Log::info('ProjectController::show timings', [
            'project' => $idProject,
            'timings' => $timings,
        ]);

        return view('projects.show', compact(
            'project',
            'users_relation',
            'activities',
            'planningProgress',
            'conductingProgress'
        ));
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
            return redirect()->back()->with('error', __('project/projects.no_permission_edit'));
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
            return redirect()->back()->with('error', __('project/projects.no_permission_edit'));
        }

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'objectives' => $request->objectives,
            'feature_review' => $request->feature_review,
            'is_public' => $request->has('is_public')
        ]);

        if ($request->copy_planning !== 'none') {
            $sourceProject = Project::findOrFail($request->copy_planning);
            $project->copyPlanningFrom($sourceProject);
        }

        $activity = __("project/projects.activity_updated");
        ActivityLogHelper::insertActivityLog($activity, 1, $project->id_project, $user->id);

        return redirect('/projects');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $activity = __("project/projects.activity_deleted", ['title' => $project->title]);
        $user = Auth::user();

        if (!$project->userHasLevel($user, '1')) {
            return redirect()->back()->with('error', __('project/projects.no_permission_delete'));
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
            return redirect()->back()->with('error', __('project/projects.no_permission_remove_member'));
        }

        $activity = __("project/projects.activity_member_removed", [
            'user' => $name_member->username,
            'title' => $project->title
        ]);

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
        $users_relation = $project->users()->withPivot('level', 'status', 'invitation_token')->get();
        $user = Auth::user();

        if (!$project->userHasLevel($user, '1')) {
            return redirect()->back()->with('error', __('project/projects.no_permission_add_member'));
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
        $email = $request->get('email_member');
        $level_member = $request->get('level_member', 2); // default: viewer
        $authUser = Auth::user();

        if (!$project->userHasLevel($authUser, '1')) {
            return redirect()->back()->with('error', __('project/projects.no_permission_add_member'));
        }

        // Tenta localizar usuário
        $existingUser = User::where('email', $email)->first();
        $isInvitedGuest = false;

        if (!$existingUser) {

            // Criar usuário convidado
            $username = strtolower(str_replace('.', '', explode('@', $email)[0]));
            $tempPassword = Str::random(10);

            $existingUser = User::create([
                'username'  => $username,
                'firstname' => $username,
                'lastname'  => '',
                'email'     => $email,
                'password'  => Hash::make($tempPassword),
                'invited'   => true,
            ]);

            $isInvitedGuest = true;
        } else {
            // Se já está no projeto, bloquear
            if ($project->users()->wherePivot('id_user', $existingUser->id)->exists()) {
                return redirect()->back()->with('error', __('project/projects.user_already_in_project'));
            }

            // Caso o usuário exista, marca como não convidado
            $isInvitedGuest = ($existingUser->invited ?? false);
        }

        // Token de convite
        $token = Str::random(40);

        // Anexa ao projeto como pending
        $project->users()->attach($existingUser->id, [
            'level'            => $level_member,
            'invitation_token' => $token,
            'status'           => 'pending'
        ]);

        // Enviar e-mail com base no tipo do usuário
        Notification::send(
            $existingUser,
            new ProjectInvitationNotification($project, $token, $isInvitedGuest)
        );

        // Notificação interna
        ProjectNotification::create([
            'user_id'    => $existingUser->id,
            'project_id' => $project->id_project,
            'type'       => 'project_invitation',
            'message'    => 'notification.project_invitation.message',
            'params'     => json_encode([
                'project_id' => $project->id_project,
                'project_title' => $project->title
            ])
        ]);

        return redirect()->back()
            ->with('success', __('project/projects.invite_sent', ['email' => $email]));
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
            return redirect()->back()->with('error', __('project/projects.no_permission_update_level'));
        }

        $member->pivot->level = $validatedData['level_member'];
        $member->pivot->save();

        $activity = __("project/projects.activity_level_updated", [
            'user' => $member->username,
            'level' => $request->validated()['level_member']
        ]);

        ActivityLogHelper::insertActivityLog($activity, 1, $project->id_project, $user->id);

        return redirect()->back()->with('success', __('project/projects.level_updated'));
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

    public function resendInvitation($idProject, $idMember)
    {
        $project = Project::findOrFail($idProject);
        $user = Auth::user();

        // Apenas Admin pode reenviar convite
        if (!$project->userHasLevel($user, '1')) {
            return redirect()->back()->with('error', __('project/projects.no_permission_resend'));
        }

        $member = $project->users()
            ->withPivot('status', 'invitation_token', 'level')
            ->where('id_user', $idMember)
            ->first();

        if (!$member) {
            return redirect()->back()->with('error', __('project/projects.member_not_found'));
        }

        // Se não está pendente, não pode reenviar
        if ($member->pivot->status !== 'pending') {
            return redirect()->back()->with('error', __('project/projects.invite_already_accepted'));
        }

        // Novo token
        $token = Str::random(40);

        $project->users()->updateExistingPivot($idMember, [
            'invitation_token' => $token
        ]);

        // Garante username se ainda não existir (caso de convidado novo)
        if (empty($member->username)) {
            $emailName = strstr($member->email, '@', true);
            $member->username = $emailName;
            $member->save();
        }

        // Detecta usuário convidado (invited flag)
        $isInvitedGuest = isset($member->invited) && $member->invited == true;

        // Notificação com link apropriado
        Notification::send($member, new ProjectInvitationNotification($project, $token, $isInvitedGuest));

        ProjectNotification::create([
            'user_id'    => $idMember,
            'project_id' => $project->id_project,
            'type'       => 'project_invitation',
            'message'    => 'notification.project_invitation.message',
            'params'     => json_encode([
                'project_id' => $project->id_project,
                'project_title' => $project->title
            ])
        ]);

        return redirect()
            ->route('projects.add_member', $project->id_project)
            ->with('success', __('project/projects.invite_resent'));
    }




    public function acceptInvitation($idProject, Request $request)
    {
        $token = $request->query('token');

        // Busca o registro na tabela 'members'
        $invitation = DB::table('members')
                        ->where('invitation_token', $token)
                        ->where('id_project', $idProject)
			->where('status', 'pending')
                        ->first();

        if (!$invitation) {
            return back()->with('error', __('project/projects.invite_invalid'));
        }

        // Atualiza o status do convite para 'accepted'
        DB::table('members')
            ->where('invitation_token', $token)
            ->where('id_project', $idProject)
            ->update([
                'status' => 'accepted',
                'invitation_token' => null  // Remove o token após ser aceito
            ]);

        $activity = __("project/projects.activity_invite_accepted");
        ActivityLogHelper::insertActivityLog($activity, 1, $idProject, $invitation->id_user);

        return redirect('/projects')->with('success', 'You have successfully joined the project!');
    }

 public function exportActivities($projectId)
    {
        $project = Project::findOrFail($projectId);
        $activities = \App\Models\Activity::where('id_project', $projectId)
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=activities.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['User', 'Activity', 'Date'];

        $callback = function() use ($activities, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($activities as $activity) {
                fputcsv($file, [
                    $activity->user->username ?? '',
                    $activity->activity,
                    $activity->created_at->format('d/m/Y H:i:s'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
