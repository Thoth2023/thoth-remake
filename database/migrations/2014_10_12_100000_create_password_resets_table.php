<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Cria a tabela 'password_resets' para armazenar solicitações de redefinição de senha.
     *
     * Campos:
     * - email: endereço de e-mail do usuário solicitante (indexado para busca rápida).
     * - token: token gerado para validação da redefinição de senha.
     * - created_at: data e hora em que a solicitação foi criada (pode ser nulo).
     *
     * Esta migration é utilizada para gerenciar o fluxo de recuperação de senha dos usuários.
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
};
