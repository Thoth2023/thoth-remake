<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar os campos de timestamp à tabela 'project'.
     *
     * Campos adicionados:
     * - created_at: armazena a data e hora de criação do registro.
     * - updated_at: armazena a data e hora da última atualização do registro.
     *
     * Métodos:
     * - up(): Executa a alteração na tabela, adicionando os campos de timestamp.
     */
    public function up(): void
    {
        Schema::table('project', function (Blueprint $table) {
            $table->timestamps();
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
