<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para alterar a coluna 'search_string' na tabela 'project_databases'.
     *
     * Esta migration modifica a coluna 'search_string', definindo seu tamanho máximo para 500 caracteres
     * e permitindo que ela seja nula (nullable).
     *
     * Métodos utilizados:
     * - Schema::table(): Permite modificar uma tabela existente no banco de dados.
     * - $table->string('search_string', 500): Altera o tipo da coluna para string com limite de 500 caracteres.
     * - ->nullable(): Permite que a coluna aceite valores nulos.
     * - ->change(): Aplica as alterações na coluna existente.
     */
    public function up(): void
    {
        Schema::table('project_databases', function (Blueprint $table) {
            $table->string('search_string', 500)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('project_databases', function (Blueprint $table) {
            $table->string('search_string', 255)->nullable()->change();
        });
    }
};
