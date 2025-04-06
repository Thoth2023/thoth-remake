<?php

namespace App\Http\Controllers; // Define o namespace do controller

use Illuminate\Http\Request; // Importa a classe Request do Laravel, usada para lidar com requisições

class ThemeController extends Controller // Criação da classe ThemeController, que herda de Controller
{
    // Método responsável por ler ou lidar com o cookie de tema
    public function readCookie()
    {
        // Essa linha, se descomentada, definiria um cookie chamado "theme" com o valor "dark" que dura 60 minutos:
        // return back()->withCookie(cookie('theme', 'dark', 60));

        // No estado atual, apenas retorna a view 'profile'
        return view('profile');
    }   
}
