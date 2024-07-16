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
            ['id_database' => 1, 'name' => 'ACM (Association for Computing Machinery)', 'link' => 'https://dl.acm.org/', 'state' => 'approved'],
            ['id_database' => 2, 'name' => 'SCOPUS', 'link' => 'https://www.scopus.com/', 'state' => 'approved'],
            ['id_database' => 3, 'name' => 'IEEE', 'link' => 'https://ieeexplore.ieee.org/', 'state' => 'approved'],
            ['id_database' => 4, 'name' => 'Springer Link', 'link' => 'https://link.springer.com/', 'state' => 'approved'],
            ['id_database' => 5, 'name' => 'Google Scholar', 'link' => 'https://scholar.google.com/', 'state' => 'approved'],
            ['id_database' => 6, 'name' => 'Science Direct', 'link' => 'https://www.sciencedirect.com/', 'state' => 'approved'],
            ['id_database' => 7, 'name' => 'PubMed', 'link' => 'https://pubmed.ncbi.nlm.nih.gov/', 'state' => 'approved'],
            ['id_database' => 8, 'name' => 'Engineering Village', 'link' => 'https://www.engineeringvillage.com/', 'state' => 'approved'],
            ['id_database' => 9, 'name' => 'IET Digital Library', 'link' => 'https://digital-library.theiet.org/', 'state' => 'approved'],
            ['id_database' => 10, 'name' => 'ProQuest', 'link' => 'https://www.proquest.com/', 'state' => 'approved'],
            ['id_database' => 11, 'name' => 'Digitel', 'link' => 'https://digitel.srv.br/', 'state' => 'approved'],
            ['id_database' => 12, 'name' => 'NetGames', 'link' => '', 'state' => 'approved'],
            ['id_database' => 13, 'name' => 'Web of Science (ISI)', 'link' => 'https://access.clarivate.com/', 'state' => 'approved'],
            ['id_database' => 14, 'name' => 'EI Compendex', 'link' => '', 'state' => 'approved'],
            ['id_database' => 15, 'name' => 'Research Gate', 'link' => 'https://www.researchgate.net/', 'state' => 'approved'],
            ['id_database' => 16, 'name' => 'Snowballing Studies', 'link' => '', 'state' => 'approved'],
        ]);
    }
}
