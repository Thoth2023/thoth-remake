<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar a coluna 'active' na tabela 'users'.
     *
     * Esta migration adiciona uma nova coluna booleana chamada 'active' à tabela 'users',
     * com valor padrão definido como true.
     *
     * Métodos utilizados:
     * - up(): Aplica a alteração na tabela, adicionando a coluna 'active'.
     *   - Schema::table(): Modifica a estrutura da tabela existente.
     *   - $table->boolean(): Cria uma nova coluna do tipo booleano.
     *   - ->default(true): Define o valor padrão da coluna como true.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
};
