<?php

namespace App\Http\Controllers;

use App\Models\SearchString;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
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

        $data = $project->termsAndSynonyms($id_project);

        return view('planning.search-string', compact('project', 'terms', 'synonyms'));
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
        $database = Database::all();
        $project = Project::findOrFail('id_project');

        $data = $project->termsAndSynonyms($id_project);

        switch ($database) {  // IMPORTANT! Refactoring
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

        if ($database != "Generic") {
            $search_string = new SearchString();
            $id_project_database = $search_string->getIdProjectDatabase($database, $id_project);
            $search_string->generateString($string, $id_project_database);

        } else {
            $search_string = new SearchString();
            $search_string->generateStringGeneric($string, $id_project);
        }
    }
}
