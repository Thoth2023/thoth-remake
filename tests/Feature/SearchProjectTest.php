<?php

namespace Tests\Feature;

use App\Models\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchProjectTest extends TestCase
{
    //use RefreshDatabase;
    use DatabaseTransactions;

    /**
     * Test searching projects by title or created_by.
     *
     * @return void
     */
    public function testSearchByTitleOrCreated()
    {
        // Create test projects
        $project1 = Project::factory()->create([
            'title' => 'Sample Project 1',
            'created_by' => 'John Doe',
        ]);

        $project2 = Project::factory()->create([
            'title' => 'Sample Project 2',
            'created_by' => 'Jane Smith',
        ]);

        // Perform search with a keyword that matches both title and created_by
        $response = $this->get('/search-project', ['searchProject' => 'Sample']);

        // Assert the response is a view
        $response->assertViewIs('projects.search-project');

        // Assert the response view has the 'projects' variable and contains the project titles
        $response->assertViewHas('projects')
                 ->assertSee($project1->title)
                 ->assertSee($project2->title);
    }
}
