<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Simulação de dados de progresso
        $triagem = 75; // Progresso da triagem
        $extracao = 50; // Progresso da extração
        $analise = 90; // Progresso da análise

        return view('dashboard.index', compact('triagem', 'extracao', 'analise'));
    }
    public function projectIndex($projectId)
    {
        // Exemplo de cálculo (substitua pela lógica real)
        $triagem = 70; // %
        $extracao = 40; // %
        $analise = 10; // %

        return view('project.dashboard', compact('triagem', 'extracao', 'analise'));
    }
}
// ...existing code...