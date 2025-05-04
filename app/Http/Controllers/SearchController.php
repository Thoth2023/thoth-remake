<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project; // Exemplo de modelo, ajuste conforme necessário

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Busca inteligente com relevância
        $results = Project::query()
            ->where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get()
            ->sortByDesc(function ($project) use ($query) {
                // Algoritmo de relevância: maior peso para títulos que contêm a palavra-chave
                $titleScore = stripos($project->title, $query) !== false ? 2 : 0;
                $descriptionScore = stripos($project->description, $query) !== false ? 1 : 0;
                return $titleScore + $descriptionScore;
            });

        return view('search.results', compact('results', 'query'));
    }
}