<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Project;

class ProjectTest extends TestCase
{
    /**
     * 
     */
    public function test_check_if_project_columns_is_correct(): void
    {
        $project = new Project;
        $expected = [
            'id_user',
            'title',
            'description',
            'objectives',
        ];

        $this->assertEquals($expected, $project->getFillable());
    }
}
