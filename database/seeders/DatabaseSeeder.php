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

        DB::table('users')->insert([
            'username' => 'admin',
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@argon.com',
            'password' => bcrypt('secret')
        ]);
        DB::table('users')->insert([
            'username' => 'Japer',
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'a@gmail.com',
            'password' => bcrypt('12345')
        ]);
        DB::table('users')->insert([
            'username' => 'Bart',
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'b@gmail.com',
            'password' => bcrypt('12345')
        ]);

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
        ]);
        DB::table('types_question')->insert([
            ['id_type' => 1, 'type' => 'Text'],
            ['id_type' => 2, 'type' => 'Multiple Choice List'],
            ['id_type' => 3, 'type' => 'Pick One List'],
        ]);

    }
}
