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
    public function testAddMember()
    {
        $project = Project::factory()->create();

        $response = $this->get("/projects/{$project->id_project}/add-member/");

        $response->assertStatus(200);

        $response->assertViewIs('projects.add_member');

        $response->assertViewHas(['project', 'users_relation']);
    }

    public function testDestroyMember()
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

    public function testAddMemberProject()
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

    public function testUpdateMemberLevel()
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

    public function testFindIdByEmail()
    {
        $project_controller = new ProjectController();
        $user = User::factory()->create();
        $user_email = $user->email;

        $userId = $project_controller->findIdByEmail($user_email);

        $this->assertEquals($user->id, $userId);
    }
}
