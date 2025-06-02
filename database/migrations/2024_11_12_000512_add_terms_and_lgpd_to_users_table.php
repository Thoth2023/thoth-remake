<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Migration para adicionar o campo 'terms_and_lgpd' à tabela 'users'.
     *
     * Esta migration adiciona uma nova coluna booleana chamada 'terms_and_lgpd' à tabela 'users',
     * que indica se o usuário aceitou os termos de uso e a LGPD (Lei Geral de Proteção de Dados).
     *
     * Métodos:
     * - up(): Aplica a alteração na tabela, adicionando a coluna 'terms_and_lgpd' com valor padrão 'false'.
     * - down(): (Normalmente utilizado para reverter a migration, removendo a coluna adicionada.)
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('terms_and_lgpd')->default(false);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('terms_and_lgpd');
        });
    }
};
