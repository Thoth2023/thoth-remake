<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
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

        $response->assertViewHas('projects');
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

        $response->assertStatus(200);

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

        $response = $this->get('/projects/' . $project->id);

        $response->assertStatus(200);

        $response->assertViewIs('projects.show');

        $response->assertViewHas('project');
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
}
