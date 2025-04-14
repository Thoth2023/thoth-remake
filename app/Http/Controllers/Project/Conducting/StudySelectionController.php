<?php

namespace App\Http\Controllers\Project\Conducting;

use App\Http\Controllers\Controller;
use App\Models\BibUpload;
use App\Models\Project;
use App\Models\Project\Conducting\Papers;
use App\Models\Project\Conducting\StudySelection;
use App\Models\ProjectDatabases;
use App\Models\StatusSelection;
use Illuminate\Http\Request;

class StudySelectionController extends Controller
{


    public function index($projectId)
    {

        $projectId = request()->segment(2);

        $idsDatabase = ProjectDatabases::where('id_project', $projectId)->pluck('id_project_database');

        $idsBib = [];

        if (count($idsDatabase) > 0) {
            $idsBib = BibUpload::whereIn('id_project_database', $idsDatabase)->pluck('id_bib')->toArray();
        }

        $papers = Papers::whereIn('id_bib', $idsBib)->get();

        return view('project.conducting.study-selection.index', [
            'papers' => $papers,
        ]);
    }

    public function translationStudySelection($file, $locale = null)
    {
        // pega o padrao do app caso nao seja passado o locale
        $locale = $locale ?? app()->getLocale();

        // nome base do arquivo
        $safeFile = basename($file);

        // arquivo de tradução
        $path = resource_path("lang/{$locale}/project/{$safeFile}.php");

        // verificacao se o arquivo de traduçao existe
        if (!file_exists($path)) {
            return response()->json(['error' => 'Arquivo de tradução não encontrado.'], 404);
        }

        // retorna um json com o conteudo do arquivo
        return response()->json(require $path);
    }
}
