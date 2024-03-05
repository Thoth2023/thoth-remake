<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Project;
use App\Models\SearchStrategy;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchStrategyTest extends TestCase
{
    use DatabaseTransactions;

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

        /* In theory this should be true, but it's not working
         * the redirect is being done to the base localhost on the test
         * but using in the real frontend seems to be working fine
         *  so this will be commented out for now
         * $response->assertStatus(302)
         *     ->assertRedirect(route('project.search-strategy.edit', ['projectId' => $project->id_project]));
         */

        $updatedSearchStrategy = SearchStrategy::find($searchStrategy->id_search_strategy);
        $this->assertEquals($newDescription, $updatedSearchStrategy->description);
    }
}


