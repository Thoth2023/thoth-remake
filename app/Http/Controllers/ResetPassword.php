<?php

// Define o namespace do controller
// Define the controller's namespace
namespace App\Http\Controllers;

// Importa classes necessárias
// Imports necessary classes
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use App\Notifications\ForgotPassword;

// Define a classe ResetPassword que estende o Controller do Laravel
// Defines the ResetPassword class, extending Laravel's Controller
class ResetPassword extends Controller
{
    // Usa o trait Notifiable para permitir o envio de notificações
    // Uses the Notifiable trait to allow sending notifications
    use Notifiable;

    // Exibe a página de redefinição de senha
    // Displays the password reset page
    public function show()
    {
        return view('auth.reset-password');
    }

    // Define qual e-mail será usado para o envio da notificação
    // Specifies which email to use for the notification
    public function routeNotificationForMail()
    {
        return request()->email;
    }

    // Envia a notificação de redefinição de senha
    // Sends the password reset notification
    public function send(Request $request)
    {
        // Valida se o campo de e-mail foi preenchido
        // Validates that the email field was provided
        $email = $request->validate([
            'email' => ['required'],
        ]);

        // Busca o usuário no banco de dados com base no e-mail informado
        // Searches the database for the user with the provided email
        $user = User::where('email', $email)->first();

        // Se o usuário for encontrado, envia a notificação
        // If the user is found, sends the notification
        if ($user) {
            $this->notify(new ForgotPassword($user->id));
            // Retorna para a página anterior com uma mensagem de sucesso
            // Returns to the previous page with a success message
            return back()->with(['success' => __('passwords.success')]);

        } else {
            // Caso o usuário não seja encontrado, retorna erro
            // If the user is not found, returns an error
            return back()->withErrors([
                'email' => __('auth.failed'),
            ]);
        }
    }
}
