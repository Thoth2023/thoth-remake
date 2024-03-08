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
            ['id_database' => 1, 'name' => 'ACM (Association for Computing Machinery)'],
            ['id_database' => 2, 'name' => 'SCOPUS'],
            ['id_database' => 3, 'name' => 'IEEE'],
            ['id_database' => 4, 'name' => 'Springer Link'],
            ['id_database' => 5, 'name' => 'Google Scholar'],
            ['id_database' => 6, 'name' => 'Science Direct'],
            ['id_database' => 7, 'name' => 'PubMed'],
            ['id_database' => 8, 'name' => 'Engineering Village'],
            ['id_database' => 9, 'name' => 'IET Digital Library'],
            ['id_database' => 10, 'name' => 'ProQuest'],
            ['id_database' => 11, 'name' => 'Digitel'],
            ['id_database' => 12, 'name' => 'NetGames'],
            ['id_database' => 13, 'name' => 'Web of Science (ISI)'],
            ['id_database' => 14, 'name' => 'EI Compendex'],
            ['id_database' => 15, 'name' => 'Research Gate'],
        ]);
    }
}
