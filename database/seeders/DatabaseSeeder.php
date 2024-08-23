<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BasesSearchSeeder::class);
        $this->call(PermissionSeeder::class);

       DB::table('levels')->insert([
            ['id_level' => 1, 'level' => 'Administrator'],
            ['id_level' => 2, 'level' => 'Viewer'],
            ['id_level' => 3, 'level' => 'Researcher'],
            ['id_level' => 4, 'level' => 'Reviser'],
        ]);
        DB::table('module')->insert([
            ['id_module' => 1, 'description' => 'Planning'],
            ['id_module' => 2, 'description' => 'Conducting'],
            ['id_module' => 3, 'description' => 'Reporting'],
            ['id_module' => 4, 'description' => 'Export'],
            ['id_module' => 5, 'description' => 'Super Administrator'],
        ]);
        DB::table('language')->insert([
            'description' => 'Portuguese',
        ]);
        DB::table('language')->insert([
            'description' => 'English',
        ]);
        DB::table('language')->insert([
            'description' => 'Spanish',
        ]);
        DB::table('language')->insert([
            'description' => 'French',
        ]);
        DB::table('language')->insert([
            'description' => 'Russian',
        ]);
        DB::table('study_type')->insert([
            ['id_study_type' => 1, 'description' => 'Book'],
            ['id_study_type' => 2, 'description' => 'Thesis'],
            ['id_study_type' => 3, 'description' => 'Article in Press'],
            ['id_study_type' => 4, 'description' => 'Article'],
            ['id_study_type' => 5, 'description' => 'Conference Paper'],
            ['id_study_type' => 6, 'description' => 'All types'],
        ]);
        DB::table('types_question')->insert([
            ['id_type' => 1, 'type' => 'Text'],
            ['id_type' => 2, 'type' => 'Multiple Choice List'],
            ['id_type' => 3, 'type' => 'Pick One List'],
        ]);


        DB::table('status_extraction')->insert([
            ['id_status' => 1, 'description' => 'Done'],
            ['id_status' => 2, 'description' => 'To Do'],
            ['id_status' => 3, 'description' => 'Removed'],
        ]);

        DB::table('status_qa')->insert([
            ['id_status' => 1, 'status' => 'Accepted'],
            ['id_status' => 2, 'status' => 'Rejected'],
            ['id_status' => 3, 'status' => 'Unclassified'],
            ['id_status' => 4, 'status' => 'Removed'],
        ]);

        DB::table('status_selection')->insert([
            ['id_status' => 1, 'description' => 'Accepted'],
            ['id_status' => 2, 'description' => 'Rejected'],
            ['id_status' => 3, 'description' => 'Unclassified'],
            ['id_status' => 4, 'description' => 'Duplicate'],
            ['id_status' => 5, 'description' => 'Removed'],
        ]);

        DB::table('status_snowballing')->insert([
            ['description' => 'Accepted'],
            ['description' => 'Rejected'],
            ['description' => 'Duplicate'],
            ['description' => 'Unclassified'],
            ['description' => 'Removed'],
        ]);

    }
}
