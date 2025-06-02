<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para alterar a coluna 'generic_search_string' na tabela 'project'.
     *
     * Esta migration modifica a coluna 'generic_search_string' para permitir até 750 caracteres
     * e torna a coluna opcional (nullable).
     *
     * Métodos utilizados:
     * - up(): Aplica as alterações na tabela, modificando o tamanho da coluna e permitindo valores nulos.
     *   - Schema::table(): Permite modificar a estrutura de uma tabela existente.
     *   - $table->string('generic_search_string', 750): Define o tipo da coluna como string com limite de 750 caracteres.
     *   - ->nullable(): Permite que a coluna aceite valores nulos.
     *   - ->change(): Indica que a coluna existente deve ser alterada conforme as novas definições.
     */
    public function up(): void
    {
        Schema::table('project', function (Blueprint $table) {
            $table->string('generic_search_string', 750)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('project', function (Blueprint $table) {
            $table->string('generic_search_string', 500)->nullable()->change();
        });
    }
};
