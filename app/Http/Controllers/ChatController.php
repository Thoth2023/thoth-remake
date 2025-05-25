<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensagem;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function users($projetoId)
    {
        // Lista todos os usuários do projeto, exceto o próprio
        return Projeto::findOrFail($projetoId)
            ->users()
            ->where('id', '!=', auth()->id())
            ->select('id', 'name')
            ->get();
    }

    public function messages(Request $request, $projetoId)
    {
        $destinatarioId = $request->query('user_id');

     return Mensagem::where('projeto_id', $projetoId)
        ->orderBy('created_at')
        ->get()
        ->map(function ($msg) {
            return [
                'usuario' => $msg->usuario ?? 'Usuário',
                'mensagem' => $msg->mensagem,
                'tipo' => $msg->tipo ?? 'texto',
                'created_at' => $msg->created_at->format('H:i'),
            ];
        });
    }

    public function store(Request $request, $projetoId)
    {
        Mensagem::create([
            'projeto_id' => $projetoId,
            'usuario' => Auth::user()->name,
            'mensagem' => $request->mensagem,
            'tipo' => 'texto',
        ]);

        return response()->json(['status' => 'ok']);
    }

    public function upload(Request $request, $projetoId)
    {
        $request->validate([
            'arquivo' => 'required|file|max:5120', // até 5MB
        ]);

        $path = $request->file('arquivo')->store('chat', 'public');

        Mensagem::create([
            'projeto_id' => $projetoId,
            'usuario' => Auth::user()->name,
            'mensagem' => $request->mensagem,
            'tipo' => 'texto',
        ]);

        return response()->json(['status' => 'ok']);
    }

}
