<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para alterar a coluna 'search_string' na tabela 'project_databases'.
     *
     * Esta migration modifica a coluna 'search_string', ajustando seu tamanho máximo para 750 caracteres
     * e permitindo valores nulos.
     *
     * Métodos utilizados:
     * - up(): Aplica as alterações na tabela, utilizando o método 'change()' para modificar a coluna existente.
     *   - Schema::table(): Permite modificar a estrutura de uma tabela existente.
     *   - $table->string('search_string', 750): Define o tipo da coluna como string com tamanho máximo de 750 caracteres.
     *   - ->nullable(): Permite que a coluna aceite valores nulos.
     *   - ->change(): Indica que a coluna existente deve ser alterada conforme as novas definições.
     */
    public function up(): void
    {
        Schema::table('project_databases', function (Blueprint $table) {
            $table->string('search_string', 750)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('project_databases', function (Blueprint $table) {
            $table->string('search_string', 500)->nullable()->change();
        });
    }
};
