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
    }
}
