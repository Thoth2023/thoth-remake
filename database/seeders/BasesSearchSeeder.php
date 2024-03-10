<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BasesSearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('data_base')->insert([
            ['id_database' => 1, 'name' => 'ACM (Association for Computing Machinery)', 'state' => 'approved'],
            ['id_database' => 2, 'name' => 'SCOPUS', 'state' => 'approved'],
            ['id_database' => 3, 'name' => 'IEEE', 'state' => 'approved'],
            ['id_database' => 4, 'name' => 'Springer Link', 'state' => 'approved'],
            ['id_database' => 5, 'name' => 'Google Scholar', 'state' => 'approved'],
            ['id_database' => 6, 'name' => 'Science Direct', 'state' => 'approved'],
            ['id_database' => 7, 'name' => 'PubMed', 'state' => 'approved'],
            ['id_database' => 8, 'name' => 'Engineering Village', 'state' => 'approved'],
            ['id_database' => 9, 'name' => 'IET Digital Library', 'state' => 'approved'],
            ['id_database' => 10, 'name' => 'ProQuest', 'state' => 'approved'],
            ['id_database' => 11, 'name' => 'Digitel', 'state' => 'approved'],
            ['id_database' => 12, 'name' => 'NetGames', 'state' => 'approved'],
            ['id_database' => 13, 'name' => 'Web of Science (ISI)', 'state' => 'approved'],
            ['id_database' => 14, 'name' => 'EI Compendex', 'state' => 'approved'],
            ['id_database' => 15, 'name' => 'Research Gate', 'state' => 'approved'],
        ]);
    }
}
