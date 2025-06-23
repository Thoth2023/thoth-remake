<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SnowballingController extends Controller
{
    public function index()
    {
        // Apenas renderiza a view sem dados
        return view('snowballing');
    }

    public function fetchReferences(Request $request)
    {
        $request->validate([
            'doi' => 'required|string',
        ]);

        $doi = $request->input('doi');

        // Chamada à API Semantic Scholar
        $response = Http::get("https://api.semanticscholar.org/graph/v1/paper/DOI:$doi", [
            'fields' => 'title,references.title,citations.title'
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Debug temporário para conferir o retorno da API
            // dd($data);

            $references = $data['references'] ?? [];
            $citations = $data['citations'] ?? [];

            // Retornar para view com os dados
            return view('snowballing', compact('references', 'citations', 'doi'));
        } else {
            // Retorna com erro na requisição
            return redirect()->back()->with('error', 'Erro ao buscar o DOI.')->withInput();
        }
    }
}
