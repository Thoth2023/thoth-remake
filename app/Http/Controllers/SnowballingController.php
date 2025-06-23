<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SnowballingController extends Controller
{
    public function index()
    {
        // Só mostra a view inicialmente, sem dados
        return view('snowballing');
    }

    public function fetchReferences(Request $request)
    {
        $request->validate([
            'doi' => 'required|string',
        ]);

        $doi = $request->input('doi');

        // Faz a requisição para a API Semantic Scholar
        $response = Http::get("https://api.semanticscholar.org/graph/v1/paper/DOI:$doi", [
            'fields' => 'title,references.title,citations.title'
        ]);

        if ($response->successful()) {
            $data = $response->json();

            $references = $data['references'] ?? [];
            $citations = $data['citations'] ?? [];

            return view('snowballing', compact('references', 'citations', 'doi'));
        } else {
            // Se falhar, volta com erro e mantém input preenchido
            return redirect()->back()->with('error', 'Erro ao buscar o DOI.')->withInput();
        }
    }
}
