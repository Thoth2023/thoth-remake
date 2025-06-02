<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   

    
    /**
     * Migration para adicionar o campo 'role' na tabela 'users' e criar/atualizar um usuário superuser.
     *
     * Campos adicionados:
     * - role: Enum ('USER', 'SUPER_USER'), padrão 'USER'.
     *
     * Funções:
     * - up(): Executa a alteração na tabela 'users' adicionando o campo 'role' e cria/atualiza um usuário com e-mail 'superuser@superuser.com', definindo-o como 'SUPER_USER'.
     *
     * Classes utilizadas:
     * - Schema: Responsável por manipular a estrutura do banco de dados.
     * - Blueprint: Utilizada para definir as colunas e alterações na tabela.
     * - User: Modelo Eloquent que representa a tabela 'users', utilizado para criar ou atualizar registros de usuário.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['USER', 'SUPER_USER'])->default('USER');
        });

        /**
         * Cria ou atualiza um usuário com o e-mail 'superuser@superuser.com' no banco de dados.
         * Se o usuário já existir, seus dados são atualizados; caso contrário, um novo usuário é criado.
         * Os dados definidos incluem: username, role, termos de uso e senha criptografada.
         */
        // User::updateOrCreate(
        //     ['email' => 'superuser@superuser.com'],
        //     [
        //         'username' => 'superuser',
        //         'role' => 'SUPER_USER',
        //         'terms' => 'required',
        //         'password' => bcrypt('superpassword'),
        //     ]
        // );
    }

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
