<?php
// Define o namespace para o controller
namespace App\Http\Controllers;

// Importa a classe Request do Laravel (mesmo que não esteja sendo usada aqui)
use Illuminate\Http\Request;

// Define a classe TermsController que herda funcionalidades do Controller base do Laravel
class TermsController extends Controller
{
    /**
     * Exibe a página de termos de uso.
     */
    public function index()
    {
        // Retorna a view localizada em resources/views/pages/terms.blade.php
        return view('pages.terms');
    }
}
