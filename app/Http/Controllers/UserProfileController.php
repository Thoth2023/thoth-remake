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
    /**
     * Exibe a view com o perfil do usuário logado.
     *
     * Retorna a página onde o usuário pode visualizar e futuramente editar seus dados de perfil.
     */
    public function show()
    {
        return view('pages.user-profile');
    }

    /**
     * Atualiza o perfil do usuário logado.
     *
     * Este método:
     * - Valida os dados recebidos do formulário.
     * - Atualiza os dados do usuário autenticado no banco.
     * - Retorna uma mensagem de sucesso ou erro.
     */
    public function update(Request $request)
    {
        // Validação dos campos enviados pelo formulário
        $attributes = $request->validate([
            'username' => ['required', 'max:255', 'min:2'],
            'firstname' => ['nullable', 'max:100', 'regex:/^[\pL\s\-]+$/u'], // Apenas letras
            'lastname' => ['nullable', 'max:100', 'regex:/^[\pL\s\-]+$/u'],  // Apenas letras
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(auth()->user()->id)], // Email único (exceto o próprio)
            'address' => ['nullable', 'max:100'],
            'city' => ['nullable', 'max:100', 'regex:/^[\pL\s\-]+$/u'],      // Apenas letras
            'country' => ['nullable', 'max:100', 'regex:/^[\pL\s\-]+$/u'],   // Apenas letras
            'postal' => ['nullable', 'max:20', 'regex:/^\d+$/'],             // Apenas números
            'about' => ['nullable', 'max:255'],
            'occupation' => ['nullable', 'max:255', 'regex:/^[\pL\s\-]+$/u'], // Apenas letras
            'institution' => ['nullable', 'max:255'],
            'lattes_link' => ['nullable', 'max:255', 'regex:/^(?:https?:\/\/)?(?:[^@\s\/]+@)?(?:[^\s\/]+\.)+[^\s\/]+\/?(?:[^\s\/]+(?:\/[^\s\/]+)*)?$/'], // Regex para validar link do Lattes
        ], [
            // Mensagens de erro personalizadas para as validações regex
            'firstname.regex' => 'O nome deve conter apenas letras.',
            'lastname.regex' => 'O sobrenome deve conter apenas letras.',
            'city.regex' => 'A cidade deve conter apenas letras.',
            'country.regex' => 'O país deve conter apenas letras.',
            'postal.regex' => 'O CEP deve conter apenas números.',
            'occupation.regex' => 'A ocupação deve conter apenas letras.',
            'lattes_link.regex' => 'O formato do link para o currículo Lattes é inválido.',
        ]);

        try {
            // Atualiza os campos do usuário autenticado com os novos valores
            auth()->user()->update([
                'username' => $request->get('username'),
                'firstname' => $request->get('firstname'),
                'lastname' => $request->get('lastname'),
                'email' => $request->get('email'),
                'address' => $request->get('address'),
                'city' => $request->get('city'),
                'country' => $request->get('country'),
                'postal' => $request->get('postal'),
                'about' => $request->get('about'),
                'occupation' => $request->get('occupation'),
                'institution' => $request->get('institution'),
                'lattes_link' => $request->get('lattes_link'),
            ]);

            // Redireciona de volta com mensagem de sucesso
            return back()->with('success', __('pages/profile.updated'));
        } catch (\Exception $e) {
            // Caso ocorra alguma exceção no processo de atualização
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Solicita exclusão dos dados pessoais do usuário.
     *
     * O processo:
     * - Envia uma notificação por e-mail solicitando confirmação.
     * - Registra o evento no log de atividades.
     * - Retorna uma resposta JSON de sucesso.
     */
    public function requestDataDeletion(Request $request)
    {
        $user = Auth::user();

        // Dispara a notificação de confirmação para o e-mail do usuário
        $user->notify(new ConfirmDeleteAccount());

        // Registra o evento de solicitação no log (importante para LGPD / rastreabilidade)
        Log::logActivity(
            action: 'delete_user_data',
            description: "Dados do usuário {$user->id} ({$user->email}) foram solicitados para exclusão em conformidade com a LGPD.",
            projectId: 1
        );

        // Adiciona mensagem flash para feedback na interface
        session()->flash('success', __('pages/profile.confirmation_message'));

        // Retorna resposta JSON indicando sucesso (usado pela interface JS)
        return response()->json(['message' => 'success']);
    }

    /**
     * Executa a exclusão ou anonimização definitiva dos dados do usuário.
     *
     * Este método é chamado após a confirmação do usuário (por exemplo, via e-mail).
     * Aqui pode-se optar entre excluir ou anonimizar os dados conforme a política da aplicação.
     */
    public function deleteUserData()
    {
        $user = Auth::user();

        // Exemplo de anonimização (não excluímos fisicamente o usuário do banco)
        $user->update([
            'username' => 'anonimo_' . Str::random(8), // Username substituído por um hash aleatório
            'firstname' => 'Anônimo',
            'lastname' => 'Anônimo',
            'email' => 'deleted' . $user->id . '@example.com', // E-mail genérico para impedir reuso
            'address' => null,
            'city' => null,
            'country' => null,
            'postal' => null,
            'institution' => null,
            'occupation' => null,
            'lattes_link' => null,
            'about' => null,
            'active' => false, // Marca a conta como inativa
        ]);

        // Mensagem de sucesso para o usuário
        session()->flash('success', __('pages/profile.exclusion-success'));

        // Redireciona o usuário para uma página de mensagem pós-exclusão
        return redirect()->route('message');
    }

    /**
     * Método de confirmação final da exclusão da conta, recebendo o ID do usuário.
     *
     * Este método:
     * - Verifica se o usuário que está tentando excluir é o mesmo que está autenticado.
     * - Chama a anonimização dos dados.
     * - Redireciona para a página de mensagem.
     */
    public function confirmDeleteAccount($id)
    {
        $user = User::findOrFail($id);

        // Verifica se o ID da solicitação corresponde ao usuário autenticado (evitar que um user delete outro)
        if ($user->id === Auth::id()) {
            // Anonimiza os dados
            $user->deleteUserData();

            // Redireciona o usuário para a página de mensagem
            return redirect()->route('message');
        }

        // Caso um usuário tente excluir outra conta que não seja a sua
        return redirect('/')->withErrors(['error' => 'Unauthorized action.']);
    }
}
