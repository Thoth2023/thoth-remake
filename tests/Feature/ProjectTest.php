<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Project\ProjectController;
use Tests\TestCase;
use App\Models\Project;
use App\Models\User;

class ProjectTest extends TestCase
{
    //use RefreshDatabase;

    /**
     * Test that only logged-in users can see the projects list.
     *
     * Action: Only Logged In Users Can See Projects List
     * Who or What to Do: projects
     * Expected Behavior: The user accessing the /projects route should be redirected to the login page.
    *
    * @return void
    */
    public function test_onlyLoggedInUsers_Projects_canSeeProjectsList(): void
    {
        $response = $this->get('/projects')
            ->assertRedirect('/login');
    }

    /**
    * Test that only logged-in users can create a project.
    *
    * Action: Only Logged In Users Can Create Project
    * Who or What to Do: project
    * Expected Behavior: The user accessing the /projects/create route should be redirected to the login page.
    *
    * @return void
    */
    public function test_onlyLoggedInUsers_Project_canCreateProject(): void
    {
        $response = $this->get('/projects/create')
            ->assertRedirect('/login');
    }

    /**
    * Test that only logged-in users can edit a project.
    *
    * Action: Only Logged In Users Can Edit Project
    * Who or What to Do: project
    * Expected Behavior: The user accessing the /projects/1/edit route should be redirected to the login page.
    *
    * @return void
    */
    public function test_onlyLoggedInUsers_Project_canEditProject(): void
    {
        $project = Project::factory()->create();
        $response = $this->get('/projects/'. $project->id_project .'/edit')
            ->assertRedirect('/login');
    }

    /**
    * Test that only logged-in users can delete a project.
    *
    * Action: Only Logged In Users Can Delete Project
    * Who or What to Do: project
    * Expected Behavior: The user attempting to delete the project at /projects/7/ should be redirected to the login page.
    *
    * @return void
    */
    public function test_onlyLoggedInUsers_Project_canDeleteProject(): void
    {
        $project = Project::factory()->create();
        $response = $this->delete('/projects/'. $project->id_project.'/')
            ->assertRedirect('/login');
    }

    /**
    * Test that the GetProjectsPage returns the projects list for a logged-in user.
    *
    * Action: Get Projects Page Logged In User Returns Projects List
    * Who or What to Do: projects
    * Expected Behavior: The response status code should be 200 (OK), the view should be 'projects.index',
    * and the view should have a variable named 'projects'.
    *
    * @return void
    */
    public function test_GetProjectsPage_LoggedInUser_ReturnsProjectsList()
    {
        Project::factory()->count(3)->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/projects');

        $response->assertStatus(200);

        $response->assertViewIs('projects.index');

        $response->assertViewHas('merged_projects');
    }

    /**
    * Test that the GetCreateProjectPage returns the create form for a logged-in user.
    *
    * Action: Get Create Project Page Logged In User Returns Create Form
    * Who or What to Do: projects
    * Expected Behavior: The response status code should be 200 (OK), and the view should be 'projects.create'.
    *
    * @return void
    */
    public function test_GetCreateProjectPage_LoggedInUser_ReturnsCreateForm()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/projects/create');

        //$response->assertStatus(200);

        $response->assertViewIs('projects.create');
    }

    /**
    * Test that storing a project with valid data by an authenticated user creates the project and redirects.
    *
    * Action: Store With Valid Data Authenticated User Creates Project And Redirects
    * Who or What to Do: project
    * Expected Behavior: The project with valid data should be stored in the database, and the response should be redirected to '/projects'.
    *
    * @return void
    */
    public function test_StoreWithValidData_AuthenticatedUser_CreatesProjectAndRedirects()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/projects', [
            'id_user' => $user->id,
            'title' => 'New Project',
            'description' => 'Description of project',
            'objectives' => 'Objectives of project',
        ]);

        $this->assertDatabaseHas('project', [
            'id_user' => $user->id,
            'title' => 'New Project',
            'description' => 'Description of project',
            'objectives' => 'Objectives of project',
        ]);

        $response->assertRedirect('/projects');
    }

    /**
    * Test that showing an existing project returns the project details.
    *
    * Action: Show Existing Project Returns Project Details
    * Who or What to Do: project
    * Expected Behavior: The response status code should be 200 (OK), the view should be 'projects.show',
    * and the view should have a variable named 'project'.
    *
    * @return void
    */
    public function test_Show_ExistingProject_ReturnsProjectDetails()
    {
        $project = Project::factory()->create();

        $response = $this->get('/projects/' . $project->id_project);

        $response->assertStatus(200);

        $response->assertViewIs('projects.show');

        $response->assertViewHas('project');
        $response->assertViewHas('users_relation', $project->users);

        // !need to implement assertViewHas for activities
        //$response->assertViewHas('activitiesactivities', $activities);
    }

    /**
    * Test that editing an existing project returns the edit form for the project.
    *
    * Action: Edit Existing Project Returns Edit Form
    * Who or What to Do: project
    * Expected Behavior: The response status code should be 200 (OK), the view should be 'projects.edit',
    * and the view should have a variable named 'project' containing the existing project.
    *
    * @return void
    */
    public function test_EditExistingProject_ReturnsEditForm()
    {
        $project = Project::factory()->create();

        $user = User::find($project->id_user);

        $response = $this->actingAs($user)->get('/projects/' . $project->id_project . '/edit');

        $response->assertStatus(200);

        $response->assertViewIs('projects.edit');

        $response->assertViewHas('project', $project);
    }

    /**
    * Test that updating a project with valid data successfully modifies the project and redirects.
    *
    * Action: Update With Valid Data Successfully Modifies Project And Redirects
    * Who or What to Do: project
    * Expected Behavior: The project with valid data should be updated in the database, and the response should be redirected to '/projects'.
    *
    * @return void
    */
    public function test_UpdateWithValidDataSuccessfullyModifies_ProjectAndRedirects()
    {
        $project = Project::factory()->create();
        $user = User::find($project->id_user);

        $response = $this->put('/projects/' . $project->id_project, [
            'title' => 'Updated Project',
            'description' => 'Updated project description',
            'objectives' => 'Updated project goals',
        ]);

        $this->assertDatabaseHas('project', [
            'id_project' => $project->id_project,
            'id_user' => $user->id,
            'title' => 'Updated Project',
            'description' => 'Updated project description',
            'objectives' => 'Updated project goals',
        ]);

        $response->assertRedirect('/projects');
    }

    /**
    * Test that deleting a project removes it from the database and redirects.
    *
    * Action: Delete Removes Project And Redirects
    * Who or What to Do: project
    * Expected Behavior: The project should be removed from the database, and the response should be redirected to '/projects'.
    *
    * @return void
    */
    public function test_DeleteRemoves_ProjectAndRedirects()
    {
        $project = Project::factory()->create();
        $user = User::find($project->id_user);

        $response = $this->actingAs($user)->delete('/projects/' . $project->id_project);

        $this->assertDatabaseMissing('project', [
            'id_project' => $project->id_project,
        ]);

        $response->assertRedirect('/projects');
    }

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
