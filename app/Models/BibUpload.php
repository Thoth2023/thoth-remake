<?php

namespace App\Models;


use App\Models\Project\Conducting\Papers;
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


    public function importPapers(array $papers, $database, int $id_project)
    {
        // Obtém o último ID dos papers do projeto e incrementa por 1
        $count_papers = $this->getLastPaperIdByProject($id_project) + 1;

        //$id_project_database = $this->getIdProjectDatabase($database, $id_project);
        $id_bib = $this->id_bib; // Usar o id_bib do próprio model BibUpload

        $insert_papers = [];
        $gen_score = $this->genScoreMin($id_project);

        foreach ($papers as $p) {


            $data = [
                'id' => $count_papers,
                'id_bib' => $id_bib,
                'type' => $p['type'] ?? '',
                'bib_key' => $p['citation-key'] ?? '',
                'title' => $p['title'] ?? '',
                'author' => $p['author'] ?? '',
                'book_title' => $p['booktitle'] ?? '',
                'volume' => $p['volume'] ?? '',
                'pages' => $p['pages'] ?? '',
                'num_pages' => $p['numpages'] ?? '',
                'abstract' => $p['abstract'] ?? '',
                'keywords' => $p['keywords'] ?? '',
                'doi' => $p['doi'] ?? '',
                'journal' => $p['journal'] ?? '',
                'issn' => $p['issn'] ?? '',
                'location' => $p['location'] ?? '',
                'isbn' => $p['isbn'] ?? '',
                'address' => $p['address'] ?? '',
                'url' => $p['url'] ?? '',
                'publisher' => $p['series'] ?? '',
                'year' => $p['year'] ?? '',
                'score' => 0,
                'status_qa' => 3,
                'id_gen_score' => $gen_score->id_general_score,
                'check_qa' => false,
                'status_selection' => 3,
                'status_extraction' => 2,
                'note' => '',
                'check_status_selection' => false,
                'data_base' => $database['value'],
            ];

            array_push($insert_papers, $data);
            $count_papers++;
        }
        //dd($insert_papers);

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
                    'id_gen_score' => $gen_score->id_general_score,
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

        // Return the number of papers inserted
        return count($insert_papers);

    }

    public function deleteAssociatedPapers()
    {
        $deletedPapersCount = 0;

        // Obter os papers associados a este arquivo (bib_upload)
        $papers = Papers::where('id_bib', $this->id_bib)->get();

        //dd($papers);

        if ($papers->isNotEmpty()) {
            $deletedPapersCount = $papers->count();

            // Excluir todos os papers associados
            Papers::where('id_bib', $this->id_bib)->delete();
        }

        return $deletedPapersCount;
    }

    // Implementar os métodos auxiliares conforme necessário
    private function getLastPaperIdByProject(int $id_project): ?int
    {
        return DB::table('papers')
            ->join('bib_upload', 'papers.id_bib', '=', 'bib_upload.id_bib')
            ->join('project_databases', 'bib_upload.id_project_database', '=', 'project_databases.id_project_database')
            ->where('project_databases.id_project', $id_project)
            ->orderByDesc('papers.id')
            ->value('papers.id');
    }

    public static function countPapersByDatabase(int $id_project, int $id_database): int
    {
        return DB::table('papers')
            ->join('bib_upload', 'papers.id_bib', '=', 'bib_upload.id_bib')
            ->join('project_databases', 'bib_upload.id_project_database', '=', 'project_databases.id_project_database')
            ->where('project_databases.id_project', $id_project)
            ->where('project_databases.id_database', $id_database)
            ->count();
    }

    private function getIdDatabase($database)
    {
        return DB::table('data_base')->where('name', $database['value'])->value('id_database');
    }


    private function getIdProjectDatabase($database, int $id_project)
    {
        return DB::table('project_databases')
            ->where('id_database', $database)
            ->where('id_project', $id_project)
            ->value('id_project_database');
    }


    private function genScoreMin(int $id_project)
    {
        // Obtém o cutoff(minimal approve) relacionado ao projeto específico
        return DB::table('qa_cutoff')
            ->where('id_project', $id_project)
            ->first(['id_general_score']);
    }

    private function getIdsMembers13(int $id_project)
    {
        return DB::table('members')->where('id_project', $id_project)->pluck('id_members');
    }

    private function getIdsPapers(int $id_bib)
    {
        return DB::table('papers')->where('id_bib', $id_bib)->pluck('id_paper');
    }


    private function getIdBib(int $id_project_database, string $name)
    {
        return DB::table('bib_upload')
            ->where('id_project_database', $id_project_database)
            ->where('name', $name)
            ->value('id_bib');
    }

}
