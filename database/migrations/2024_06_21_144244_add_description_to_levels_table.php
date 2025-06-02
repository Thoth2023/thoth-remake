<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar a coluna 'description' (string, pode ser nula) à tabela 'levels'.
     *
     * Métodos utilizados:
     * - up(): Aplica a alteração na tabela, adicionando a coluna 'description' como string e permitindo valores nulos.
     * - Schema::table(): Modifica a estrutura de uma tabela existente.
     * - $table->string('description')->nullable(): Cria uma nova coluna do tipo string chamada 'description' que aceita valores nulos.
     */
    public function up(): void
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
