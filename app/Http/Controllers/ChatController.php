<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensagem;

class ChatController extends Controller
{
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
        return Mensagem::create([
            'projeto_id' => $projeto_id,
            //'usuario' => $request->usuario,
            'usuario' => auth()->user()->name,
            'mensagem' => $request->mensagem,
        ]);
    }

}
