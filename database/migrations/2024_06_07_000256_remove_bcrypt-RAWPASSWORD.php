<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    /**
     * Migration para atualizar ou criar um usuário superuser no banco de dados.
     *
     * Este método `up` utiliza o método estático `updateOrCreate` do modelo User para garantir
     * que exista um usuário com o e-mail 'superuser@superuser.com'. Caso não exista, ele será criado;
     * caso já exista, seus dados serão atualizados conforme os valores fornecidos.
     *
     * Métodos utilizados:
     * - User::updateOrCreate(array $attributes, array $values): Cria ou atualiza um registro no banco de dados
     *   baseado nos atributos fornecidos.
     *
     * Observação: A senha está sendo definida em texto plano, o que pode não ser seguro. Considere utilizar
     * hash de senha apropriado.
     */
    // public function up(): void
    // {
    //     User::updateOrCreate(
    //         ['email' => 'superuser@superuser.com'],
    //         [
    //             'username' => 'superuser',
    //             'role' => 'SUPER_USER',
    //             'terms' => 'required',
    //             'password' => 'superpassword',
    //         ]
    //     );
    // }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
