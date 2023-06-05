<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\ProjectController;
use App\Models\User;
use App\Models\Project;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    /**
     * Tests the behavior of accessing the "add member" page for a project.
     *
     * Action: accessAddMemberPage
     * Who or What to do: Project
     * Expected Behavior: The response should have a status of 200 (OK) and the view returned should be "projects.add_member".
     *
     * @return void
     */
    public function testAccessAddMemberPage()
    {
        $project = Project::factory()->create();

        $response = $this->get("/projects/{$project->id_project}/add-member/");

        $response->assertStatus(200);

        $response->assertViewIs('projects.add_member');

        $response->assertViewHas(['project', 'users_relation']);
    }

    /**
     * Tests the behavior of removing a member from a project.
     *
     * Action: destroyMember
     * Who or What to do: Project
     * Expected Behavior: Member should be successfully removed from the project and the database should reflect the change.
     *
     * @return void
     */
    public function testRemoveMemberFromProject()
    {
        $project = Project::factory()->create();

        $user = User::factory()->create();

        $project->users()->attach($project->id_project, ['id_user' => $user->id, 'level' => 1]);

        $response = $this->delete("/projects/{$project->id_project}/add-member/{$user->id}");

        $this->assertDatabaseMissing('members', [
            'id_user' => $user->id,
            'id_project' => $project->id_project,
        ]);

        $response->assertRedirect();
        $response->assertStatus(302);
    }

    /**
     * Tests the behavior of adding a member to a project.
     *
     * Action: addMemberProject
     * Who or What to do: Project
     * Expected Behavior: Member should be successfully added to the project and the database should reflect the change.
     *
     * @return void
     */
    public function testAddMemberToProject()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user);

        $request = [
            'email_member' => $user->email,
            'level_member' => 2,
        ];

        $response = $this->put("/projects/{$project->id_project}/add-member", $request);

        $this->assertDatabaseHas('members', [
            'id_project' => $project->id_project,
            'id_user' => $user->id,
            'level' => '2',
        ]);

        $response->assertRedirect();
        $response->assertStatus(302);
    }

    /**
     * Tests the behavior of updating the member level in a project.
     *
     * Action: updateMemberLevel
     * Who or What to do: Project
     * Expected Behavior: The member's level should be successfully updated in the project and the database should reflect the change.
     *
     * @return void
     */
    public function testUpdateMemberLevelInProject()
    {
        $project = Project::factory()->create();

        $user = User::factory()->create();

        $project->users()->attach($project->id_project, ['id_user' => $user->id, 'level' => 2]);

        $this->actingAs($user);

        $request = [
            'level_member' => 4,
        ];

        $response = $this->put("/projects/{$project->id_project}/members/{$user->id}/update-level", $request);

        $this->assertDatabaseHas('members', [
            'id_project' => $project->id_project,
            'id_user' => $user->id,
            'level' => 4,
        ]);

        $response->assertRedirect();
        $response->assertStatus(302);
    }

    /**
     * Tests the behavior of finding a user ID by email.
     *
     * Action: findIdByEmail
     * Who or What to do: ProjectController
     * Expected Behavior: The user ID should be successfully found based on the provided email.
     *
     * @return void
     */
    public function testFindUserIdByEmail()
    {
        $project_controller = new ProjectController();
        $user = User::factory()->create();
        $user_email = $user->email;

        $userId = $project_controller->findIdByEmail($user_email);

        $this->assertEquals($user->id, $userId);
    }
}
