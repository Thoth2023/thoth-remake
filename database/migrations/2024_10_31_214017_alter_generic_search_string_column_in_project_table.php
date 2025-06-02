<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para alterar a coluna 'generic_search_string' na tabela 'project'.
     *
     * Esta migration modifica a coluna 'generic_search_string' para permitir valores nulos (nullable)
     * e define seu tamanho máximo para 500 caracteres.
     *
     * Métodos utilizados:
     * - Schema::table(): Permite modificar a estrutura de uma tabela existente no banco de dados.
     * - $table->string(): Altera o tipo da coluna para string (VARCHAR) com tamanho especificado.
     * - nullable(): Permite que a coluna aceite valores nulos.
     * - change(): Aplica as alterações na coluna existente.
     */
    public function up(): void
    {
        Schema::table('project', function (Blueprint $table) {
            $table->string('generic_search_string', 500)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('project', function (Blueprint $table) {
            $table->string('generic_search_string', 255)->nullable()->change();
        });
    }
};
