<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    /**
     * Migration para adicionar a coluna 'search_string' à tabela 'project_databases'.
     *
     * Métodos:
     * - up(): Aplica a migration, adicionando uma nova coluna do tipo string chamada 'search_string' 
     *         que pode ser nula (nullable) à tabela 'project_databases'.
     *
     * Utiliza:
     * - Schema::table(): Permite modificar uma tabela existente no banco de dados.
     * - Blueprint $table->string(): Cria uma nova coluna do tipo string.
     * - nullable(): Permite que a coluna aceite valores nulos.
     */
    public function up(): void
    {
        Schema::table('project_databases', function (Blueprint $table) {
            $table->string('search_string')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_databases', function (Blueprint $table) {
            //
        });
    }
};
