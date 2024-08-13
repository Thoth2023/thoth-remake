<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSnowballingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('status_snowballing')->insert([
            ['description' => 'Accepted'],
            ['description' => 'Rejected'],
            ['description' => 'Duplicate'],
            ['description' => 'Unclassified'],
            ['description' => 'Removed'],
        ]);
    }
}
