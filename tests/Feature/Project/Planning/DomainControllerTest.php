<?php

namespace Tests\Feature\Project\Planning;

use App\Models\Domain;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DomainControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private $user;
    private $project;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a project for testing
        $this->project = Project::factory()->create();
        $this->user =  User::factory()->create();
    }

    /** @test */
    public function it_can_store_a_new_domain()
    {
        // Arrange
        $data = [
            'id_project' => $this->project->id_project,
            'description' => $this->faker->sentence,
        ];

        // Act
        $response = $this->actingAs($this->user)
            ->post(route('project.planning.domains.store', ['projectId' => $this->project->id_project]), $data);

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseHas('domains', $data);
    }

    /** @test */
    public function it_can_update_an_existing_domain()
    {
        // Arrange
        $domain = Domain::factory()->create(['id_project' => $this->project->id_project]);
        $newDescription = $this->faker->sentence;

        // Act
        $response = $this->actingAs($this->user)
            ->put(route('project.planning.domains.update', ['projectId' => $this->project->id_project, 'domain' => $domain]), [
                'description' => $newDescription,
            ]);

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseHas('domains', ['id' => $domain->id, 'description' => $newDescription]);
    }

    /** @test */
    public function it_can_delete_an_existing_domain()
    {
        // Arrange
        $domain = Domain::factory()->create(['id_project' => $this->project->id_project]);

        // Act
        $response = $this->actingAs($this->user)
            ->delete(route('project.planning.domains.destroy', ['projectId' => $this->project->id_project, 'domain' => $domain]));

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseMissing('domains', ['id' => $domain->id]);
    }
}

