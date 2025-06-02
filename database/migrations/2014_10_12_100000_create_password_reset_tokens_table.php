<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Cria a tabela 'password_reset_tokens' para armazenar tokens de redefinição de senha.
     *
     * Estrutura da tabela:
     * - email: chave primária, identifica o usuário que solicitou a redefinição.
     * - token: token gerado para a redefinição de senha.
     * - created_at: data e hora em que o token foi criado, pode ser nulo.
     *
     * Esta migration é utilizada para gerenciar o processo de recuperação de senha dos usuários.
     */
    public function up(): void
    {
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
    }
};
