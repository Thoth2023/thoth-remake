<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela 'personal_access_tokens' para armazenar tokens de acesso pessoal.
     *
     * Esta migration define a estrutura da tabela, incluindo:
     * - ID primário autoincrementável.
     * - Relacionamento polimórfico ('tokenable') para associar o token a diferentes modelos.
     * - Nome do token.
     * - Token único (string de 64 caracteres).
     * - Abilidades/operações permitidas para o token (opcional).
     * - Data/hora do último uso do token (opcional).
     * - Data/hora de expiração do token (opcional).
     * - Timestamps de criação e atualização.
     */
    public function up(): void
    {
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
