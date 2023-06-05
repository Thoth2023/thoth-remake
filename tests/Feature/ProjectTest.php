<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use App\Models\Project;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    
    public function testDestroyMember()
    {
        $project = Project::factory()->create();
        $member = User::factory()->create();
        $project->users()->attach($member->id);

        $response = $this->delete("/projects/{idProject}/add_member/{idMember}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('project_user', [
            'project_id' => $project->id,
            'user_id' => $member->id,
        ]);
    }
}
