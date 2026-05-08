<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensagem;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($projeto_id)
    {
        return view('chat', compact('projeto_id'));
    }

    public function fetchMessages($projeto_id)
    {
        return Mensagem::where('projeto_id', $projeto_id)->get();
    }

    public function sendMessage(Request $request, $projeto_id)
    {
        // Pegar o usuário logado
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Usuário não autenticado'], 401);
        }

        // Usar o nome do usuário logado
        $nomeusuario = $user->firstname . ' ' . $user->lastname;

        return Mensagem::create([
            'projeto_id' => $projeto_id,
            'usuario' => $nomeusuario,
            'mensagem' => $request->mensagem,
        ]);
    }
}
