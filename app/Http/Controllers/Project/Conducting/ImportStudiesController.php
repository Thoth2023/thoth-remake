<?php

namespace App\Http\Controllers\Project\Conducting;

use App\Http\Controllers\Controller;
use App\Models\Database;
use Illuminate\Http\Request;

class ImportStudiesController extends Controller
{
    public function index() {
    $databases = Database::all(); // Recupera todos os bancos de dados
    return view('livewire.conducting.import-studies', compact('databases'));
    }

    public function import(Request $request)
    {
        // completar com a lógica para importar estudos
    }

    public function delete($id)
    {
        // completar com a lógica para excluir um estudo
    }
}