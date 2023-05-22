<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;

class ProjectTest extends TestCase
{
    /**
     * 
     */
    public function test_only_logged_in_users_can_see_projects_list(): void
    {
        $response = $this->get('/projects')
            ->assertRedirect('/login');
    }

    /**
     * 
     */
    public function test_only_logged_in_users_can_create_project(): void
    {
        $response = $this->get('/projects/create')
            ->assertRedirect('/login');
    }

    /**
     * 
     */
    public function test_only_logged_in_users_can_edit_project(): void
    {
        $response = $this->get('/projects/1/edit')
            ->assertRedirect('/login');
    }

    /**
     * 
     */
    // public function test_only_logged_in_users_can_delete_project(): void
    // {
    //     $response = $this->get('/projects/4/delete')
    //         ->assertRedirect('/login');
    // }

    public function test_if_project_is_redirected_to_route_projects_index_after_created(): void
    {
        $project = Project::create([
            'id_user' => 2,
            'title' => 'Project 1',
            'description' => 'Project description',
            'objectives' => 'Objectives project',
        ]);
        $this->assertDatabaseHas('project', [
            'title' => 'Project 1',
        ]);
    }
}
