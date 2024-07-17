<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BibUpload extends Model
{

    use HasFactory;

    protected $table = 'bib_upload';
    protected $primaryKey = 'id_bib';
    public $timestamps = false;

    protected $fillable = ['name', 'id_project_database'];

    public function studies()
    {
        return $this->hasMany(Study::class, 'id_bib', 'id_bib');
    }

    public function projectDatabase()
    {
        return $this->belongsTo(ProjectDatabases::class, 'id_project_database', 'id_project_database');
    }


    public function importPapers(array $papers, string $database, string $name, int $id_project)
    {
        $count_papers = $this->countPapersByProject($id_project);
        $id_database = $this->getIdDatabase($database);
        $id_project_database = $this->getIdProjectDatabase($id_database, $id_project);

        $data3 = [
            'name' => $name,
            'id_project_database' => $id_project_database,
        ];
        $id_bib = DB::table('bib_upload')->insertGetId($data3);

        $insert_papers = [];
        $gen_score = $this->genScoreMin($id_project);

        foreach ($papers as $p) {
            $data = [
                'id' => $count_papers,
                'id_bib' => $id_bib,
                'type' => $p['EntryType'] ?? '',
                'bib_key' => $p['EntryKey'] ?? '',
                'title' => $p['Fields']['title'] ?? '',
                'author' => $p['Fields']['author'] ?? '',
                'book_title' => $p['Fields']['booktitle'] ?? '',
                'volume' => $p['Fields']['volume'] ?? '',
                'pages' => $p['Fields']['pages'] ?? '',
                'num_pages' => $p['Fields']['numpages'] ?? '',
                'abstract' => $p['Fields']['abstract'] ?? '',
                'keywords' => $p['Fields']['keywords'] ?? '',
                'doi' => $p['Fields']['doi'] ?? '',
                'journal' => $p['Fields']['journal'] ?? '',
                'issn' => $p['Fields']['issn'] ?? '',
                'location' => $p['Fields']['location'] ?? '',
                'isbn' => $p['Fields']['isbn'] ?? '',
                'address' => $p['Fields']['address'] ?? '',
                'url' => $p['Fields']['url'] ?? '',
                'publisher' => $p['Fields']['series'] ?? '',
                'year' => $p['Fields']['year'] ?? '',
                'score' => 0,
                'status_qa' => 3,
                'id_gen_score' => $gen_score,
                'check_qa' => false,
                'status_selection' => 3,
                'status_extraction' => 2,
                'note' => '',
                'check_status_selection' => false,
                'data_base' => $id_database,
            ];

            array_push($insert_papers, $data);
            $count_papers++;
        }

        DB::table('papers')->insert($insert_papers);

        $members = $this->getIdsMembers13($id_project);
        $id_papers = $this->getIdsPapers($id_bib);

        $status = [];
        $status_qa = [];
        foreach ($members as $mem) {
            foreach ($id_papers as $paper) {
                $insert = [
                    'id_paper' => $paper,
                    'id_member' => $mem,
                    'id_status' => 3,
                    'note' => '',
                ];

                $insert_qa = [
                    'id_paper' => $paper,
                    'id_member' => $mem,
                    'id_status' => 3,
                    'note' => '',
                    'score' => 0,
                    'id_gen_score' => $gen_score,
                ];
                array_push($status, $insert);
                array_push($status_qa, $insert_qa);
            }
        }

        DB::table('papers_selection')->insert($status);
        DB::table('papers_qa')->insert($status_qa);

        DB::table('project')
            ->where('id_project', $id_project)
            ->update(['c_papers' => $count_papers]);
    }

    public function deleteBib(string $database, string $name, int $id_project): int
    {
        $id_database = $this->getIdDatabase($database);
        $id_project_database = $this->getIdProjectDatabase($id_database, $id_project);
        $id_bib = $this->getIdBib($id_project_database, $name);

        $papers_count = DB::table('papers')->where('id_bib', $id_bib)->count();

        DB::table('bib_upload')->where('id_bib', $id_bib)->delete();

        return $papers_count;
    }

    // Implementar os métodos auxiliares conforme necessário
    private function countPapersByProject(int $id_project)
    {
        // Implementar a lógica
    }

    private function getIdDatabase(string $database)
    {
        // Implementar a lógica
    }

    private function getIdProjectDatabase(int $id_database, int $id_project)
    {
        // Implementar a lógica
    }

    private function genScoreMin(int $id_project)
    {
        // Implementar a lógica
    }

    private function getIdsMembers13(int $id_project)
    {
        // Implementar a lógica
    }

    private function getIdsPapers(int $id_bib)
    {
        // Implementar a lógica
    }

    private function getIdBib(int $id_project_database, string $name)
    {
        // Implementar a lógica
    }


}
