<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar colunas de timestamps (created_at e updated_at) à tabela 'levels'.
     *
     * Métodos utilizados:
     * - up(): Aplica a alteração na tabela, adicionando as colunas de timestamps.
     *   - Schema::table(): Modifica a estrutura da tabela existente.
     *   - $table->timestamps(): Adiciona as colunas 'created_at' e 'updated_at' do tipo timestamp.
     */
    public function up(): void
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('levels', function (Blueprint $table) {
            $table->timestamps();
        });
    }
};
