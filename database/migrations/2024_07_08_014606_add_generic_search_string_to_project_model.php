<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    /**
     * Migration para adicionar a coluna 'generic_search_string' à tabela 'project'.
     *
     * Métodos:
     * - up(): Executa a alteração na tabela, adicionando a coluna 'generic_search_string' do tipo string, que pode ser nula.
     *
     * Utiliza:
     * - Schema::table(): Permite modificar a estrutura de uma tabela existente.
     * - Blueprint $table->string(): Cria uma nova coluna do tipo string.
     * - nullable(): Permite que a coluna aceite valores nulos.
     */
    public function up(): void
    {
        Schema::table('project', function (Blueprint $table) {
            $table->string('generic_search_string')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project', function (Blueprint $table) {
            //
        });
    }
};
