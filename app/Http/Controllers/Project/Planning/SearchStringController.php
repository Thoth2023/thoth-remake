<?php

namespace App\Http\Controllers;

use App\Models\SearchString;
use App\Models\SearchStringGeneric;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Project;
use App\Models\Term;
use App\Models\Synonym;
use App\Models\DataBase;

class SearchStringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id_project)
    {
        $project = Project::findOrFail($id_project);
        $terms = $project->terms;
        $synonyms = $project->synonyms;

        $searchStrings = $this->getSearchStrings($id_project);
        dd($searchStrings);

        return view('planning.search-string', compact('project', 'terms', 'synonyms', 'searchStrings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_term(Request $request, $id_project)
    {
        $project = Project::findOrFail($id_project);

        $project->terms()->create([
            'description' => $request->input('description_term'),
        ]);

        return redirect("/planning/".$id_project."/search-string");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_synonym(Request $request, $id_project)
    {
        $id_term = $request->input('termSelect');
        $term = Term::findOrFail($id_term);
        $term->synonyms()->create([
            'description' => $request->input('description_synonym'),
        ]);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_term(Request $request, $id_term)
    {
        $term = Term::findOrFail($id_term);
        $term->description = $request->input('term-description');
        $term->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy_term($id_term)
    {
        $term = Term::findOrFail($id_term);
        $term->delete();
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_synonym(Request $request, $id_synonym)
    {
        $synonym = Synonym::findOrFail($id_synonym);
        $synonym->description = $request->input('synonym-description');
        $synonym->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy_synonym($id_synonym)
    {
        $synonym = Synonym::findOrFail($id_synonym);
        $synonym->delete();
        return redirect()->back();
    }

    public function generate_string($id_project)
    {
        $project = Project::findOrFail($id_project);
        $databases = $project->databases;

        $data = $project->termsAndSynonyms($id_project);

        foreach ($databases as $database) {
            $string = '';
            switch ($database->name) {
                case "SCOPUS":
                    $string = 'TITLE-ABS-KEY ';
                    break;
                case "IEEE":
                    $string = '';
                    break;
                case "SCIENCE DIRECT":
                    $string = '';
                    break;
                case "ENGINEERING VILLAGE":
                    $string = '(';
                    break;
                case "ACM":
                    $string = '';
                    break;
                case "SPRINGER LINK":
                    $string = '';
                    break;
                default:
                    break;
            }

            $count = 0;
            foreach ($data as $term) {
                if ($count > 0) {
                    $string .= " AND ";
                }
                if ($database == "ENGINEERING VILLAGE") {
                    $string .= '(';
                }
                $string .= "(";

                if (preg_match('/\s/', $term['term'])) {
                    $string .= '"' . $term['term'] . '"';
                } else {
                    $string .= $term['term'];
                }

                foreach ($term['synonyms'] as $synonym) {
                    if ($database == "ACM") {
                        $string .= " ";
                    } else {
                        $string .= " OR ";
                    }
                    if (preg_match('/\s/', $synonym)) {
                        $string .= '"' . $synonym . '"';
                    } else {
                        $string .= $synonym;
                    }
                }
                $string .= ")";
                if ($database == "ENGINEERING VILLAGE") {
                    $string .= ' WN KY)';
                }
                $count++;
            }
            if ($database == "ENGINEERING VILLAGE") {
                $string .= ' AND ({english} WN LA)';
            }

            // Verifique se $database não é "Generic" antes de executar o código apropriado

            if ($database->name != "Generic") {
                $search_string = new SearchString();
                $search_string->description = $string;
                $search_string->id_project_database = $search_string->getIdProjectDatabase($database->name, $id_project);
                $search_string->save();
            } else {
                $search_string_generic = new SearchStringGeneric();
                $search_string_generic->description = $string;
                $search_string_generic->id_project = $id_project;
                $search_string_generic->save();
            }
        }
    }

    public function generateString($id_project)
    {

        $this->generate_string($id_project);

        return redirect()->back();
    }

    public function getSearchStrings($id_project): array
    {
        $sss = [];

        $genericSearchStrings = SearchStringGeneric::where('id_project', $id_project)->get();

        foreach ($genericSearchStrings as $row) {
            $ss = new SearchString();
            $ss->description($row->description);

            $db = new Database();
            $db->name = "Generic";
            $db->link = "#";
            $ss->database = $db;
            $sss[] = $ss;
        }

        $searchStrings = SearchString::select('search_string.description', 'data_base.name', 'data_base.link')
            ->join('project_databases', 'project_databases.id_project_database', '=', 'search_string.id_project_database')
            ->join('data_base', 'data_base.id_database', '=', 'project_databases.id_database')
            ->where('id_project', $id_project)
            ->with('data_base')
            ->get();


        foreach ($searchStrings as $row) {
            $ss = new SearchString();
            $ss->description = $row->description;
            $ss->database = $row->database;

            $sss[] = $ss;
        }

        return $sss;
    }
}
