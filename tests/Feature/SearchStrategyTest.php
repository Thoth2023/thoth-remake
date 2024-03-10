<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use App\Models\SearchStrategy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchStrategyTest extends TestCase
{
    use RefreshDatabase;

    public function testSearchStrategyIndex()
    {
        $project = Project::factory()->create();

        $response = $this
            ->get(route('project.search-strategy.edit', ['projectId' => $project->id_project]));

        $response->assertStatus(200)
            ->assertViewIs('project.planning.search-strategy')
            ->assertViewHas('project', $project);
    }

    public function testSearchStrategyUpdate()
    {
        $project = Project::factory()->create();
        $searchStrategy = SearchStrategy::factory()
            ->create(['id_project' => $project->id_project]);
        $newDescription = 'New search strategy description';

        $response = $this->post(route('project.search-strategy.update', ['projectId' => $project->id_project]), [
            'search_strategy' => $newDescription,
        ]);

        $updatedSearchStrategy = SearchStrategy::find($searchStrategy->id_search_strategy);
        $this->assertEquals($newDescription, $updatedSearchStrategy->description);
    }
}


