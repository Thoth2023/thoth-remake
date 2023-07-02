<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types_question')->insert([
            'type' => 'Text',
        ]);

        DB::table('types_question')->insert([
            'type' => 'Multiple Choice List',
        ]);

        DB::table('types_question')->insert([
            'type' => 'Pick One List',
        ]);
    }
}
