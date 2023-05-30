<?php

namespace Tests\Unit;

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
        $searchStrategy = SearchStrategy::factory()->create(['project_id' => $project->id]);

        $response = $this->get(route('search-strategy.index', ['projectId' => $project->id]));

        $response->assertStatus(200)
            ->assertViewIs('search_strategy')
            ->assertViewHas('project', $project)
            ->assertViewHas('searchStrategy', $searchStrategy);
    }

    public function testSearchStrategyUpdate()
    {
        $project = Project::factory()->create();
        $searchStrategy = SearchStrategy::factory()->create(['project_id' => $project->id]);
        $newDescription = 'New search strategy description';

        $response = $this->post(route('search-strategy.update', ['projectId' => $project->id]), [
            'search_strategy' => $newDescription,
        ]);

        $response->assertStatus(302)
            ->assertRedirect(route('search-strategy.index', ['projectId' => $project->id]));

        $updatedSearchStrategy = SearchStrategy::find($searchStrategy->id);
        $this->assertEquals($newDescription, $updatedSearchStrategy->description);
    }
}

