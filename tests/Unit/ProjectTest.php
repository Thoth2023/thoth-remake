<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;
use App\Models\Project;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectTest extends TestCase
{
    use DatabaseTransactions;

    /**
    * Test if the columns of the Project model are correct.
    *
    * Action: checkColumns
    * Who or What to Do: project
    * Expected Behavior: The fillable columns should match the expected array.
    *
    * @return void
    */
    public function test_checkColumns_of_project_model(): void
    {
        $project = new Project;
        $expected = [
            'id_user',
            'title',
            'description',
            'objectives',
            'created_by',
        ];

        $this->assertEquals($expected, $project->getFillable());
    }

    /**
    * Test the table attribute of the Project model.
    *
    * Action: testTableAttribute
    * Who or What to Do: project
    * Expected Behavior: The table name should be 'project'.
    *
    * @return void
    */
    public function test_testTableAttribute_of_project_model()
    {
        $project = new Project();
        $this->assertEquals('project', $project->getTable());
    }


    /**
    * Test the primary key attribute of the Project model.
    *
    * Action: testPrimaryKeyAttribute
    * Who or What to Do: project
    * Expected Behavior: The primary key name should be 'id_project'.
    *
    * @return void
    */
    public function test_testPrimaryKeyAttribute_of_project_model()
    {
        $project = new Project();
        $this->assertEquals('id_project', $project->getKeyName());
    }

    /**
    * Test the timestamps attribute of the Project model.
    *
    * Action: testTimestampsAttribute
    * Who or What to Do: project
    * Expected Behavior: The timestamps attribute should be set to false.
    *
    * @return void
    */
    public function test_testTimestampsAttribute_of_project_model()
    {
        $project = new Project();
        $this->assertFalse($project->timestamps);
    }
}

