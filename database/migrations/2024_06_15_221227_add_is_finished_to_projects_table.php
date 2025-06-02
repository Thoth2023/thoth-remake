<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar a coluna 'is_finished' na tabela 'project'.
     *
     * Esta migration adiciona um campo booleano chamado 'is_finished' à tabela 'project',
     * com valor padrão 'false'. Este campo pode ser utilizado para indicar se um projeto foi finalizado.
     *
     * Métodos utilizados:
     * - up(): Executa as alterações na tabela, adicionando a nova coluna.
     *   - Schema::table(): Modifica a estrutura da tabela existente.
     *   - $table->boolean(): Cria uma nova coluna do tipo boolean.
     *   - default(): Define o valor padrão da coluna.
     */
    public function up(): void
    {
        Schema::table('project', function (Blueprint $table) {
            $table->boolean('is_finished')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project', function (Blueprint $table) {
            $table->dropColumn('is_finished');
        });
    }
};
