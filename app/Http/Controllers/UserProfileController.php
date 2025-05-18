<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ConfirmDeleteAccount;
use App\Utils\ActivityLogHelper as Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    // Show the user profile view
    public function show()
    {
        return view('pages.user-profile');
    }

    // Update the user profile
    public function update(Request $request)
    {
        // Validate the request data
        $attributes = $request->validate([
            'username' => ['required', 'max:255', 'min:2'],
            'firstname' => ['nullable', 'max:100', 'regex:/^[\pL\s\-]+$/u'],
            'lastname' => ['nullable', 'max:100', 'regex:/^[\pL\s\-]+$/u'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(auth()->user()->id)],
            'address' => ['nullable', 'max:100'],
            'city' => ['nullable', 'max:100', 'regex:/^[\pL\s\-]+$/u'],
            'country' => ['nullable', 'max:100', 'regex:/^[\pL\s\-]+$/u'],
            'postal' => ['nullable', 'max:20', 'regex:/^\d+$/'],
            'about' => ['nullable', 'max:255'],
            'occupation' => ['nullable', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
            'institution' => ['nullable', 'max:255'],
            'lattes_link' => ['nullable', 'max:255', 'regex:/^(?:https?:\/\/)?(?:[^@\s\/]+@)?(?:[^\s\/]+\.)+[^\s\/]+\/?(?:[^\s\/]+(?:\/[^\s\/]+)*)?$/'],
        ], [
            'firstname.regex' => 'O nome deve conter apenas letras.',
            'lastname.regex' => 'O sobrenome deve conter apenas letras.',
            'city.regex' => 'A cidade deve conter apenas letras.',
            'country.regex' => 'O país deve conter apenas letras.',
            'postal.regex' => 'O CEP deve conter apenas números.',
            'occupation.regex' => 'A ocupação deve conter apenas letras.',
            'lattes_link.regex' => 'O formato do link para o currículo Lattes é inválido.',
        ]);


        try{
            // Update the authenticated user's profile with the validated data
            auth()->user()->update([
                'username' => $request->get('username'),
                'firstname' => $request->get('firstname'),
                'lastname' => $request->get('lastname'),
                'email' => $request->get('email') ,
                'address' => $request->get('address'),
                'city' => $request->get('city'),
                'country' => $request->get('country'),
                'postal' => $request->get('postal'),
                'about' => $request->get('about'),
                'occupation' => $request->get('occupation'),
                'institution' => $request->get('institution'),
                'lattes_link' => $request->get('lattes_link'),
            ]);
            // Redirect back to the previous page with a success message
            return back()->with('success',  __('pages/profile.updated'));
        }catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function requestDataDeletion(Request $request)
    {
        $user = Auth::user();

        // Enviar o e-mail de confirmação
        $user->notify(new ConfirmDeleteAccount());

        // Logar a ação antes de apagar os dados
        Log::logActivity(
            action: 'delete_user_data',
            description: "Dados do usuário {$user->id} ({$user->email}) foram solicitados para exclusão em conformidade com a LGPD.",
            projectId: 1
        );
        // Armazenar mensagem de sucesso na sessão
        session()->flash('success', __('pages/profile.confirmation_message'));

        return response()->json(['message' => 'success']);
    }

    public function deleteUserData()
    {
        $user = Auth::user();

        // Excluir ou anonimizar dados relacionados, como:
        // Pedidos, histórico de navegação, preferências, etc.

        // Exemplo de anonimização de dados
        $user->update([
            'username' => 'anonimo_' . Str::random(8), // Anonimizar o username com um hash único
            'firstname' => 'Anônimo',
            'lastname' => 'Anônimo',
            'email' => 'deleted' . $user->id . '@example.com',
            'address' => null,
            'city' => null,
            'country' => null,
            'postal' => null,
            'institution' => null,
            'occupation' => null,
            'lattes_link' => null,
            'about' => null,
            'active' => false, // Desativar conta
        ]);

        session()->flash('success', __('pages/profile.exclusion-success'));
        return redirect()->route('message');
    }

    public function confirmDeleteAccount($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            // Realiza a anonimização dos dados do usuário
            $user->deleteUserData();

            // Redireciona para a página de mensagem sem deslogar imediatamente
            return redirect()->route('message');
        }

        return redirect('/')->withErrors(['error' => 'Unauthorized action.']);
    }


}
