<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chaves estrangeiras à tabela 'evaluation_criteria'.
     *
     * Campos afetados:
     * - id_member: Referencia o campo 'id_members' da tabela 'members'.
     * - id_paper: Referencia o campo 'id_paper' da tabela 'papers'.
     * - id_criteria: Referencia o campo 'id_criteria' da tabela 'criteria'.
     *
     * Funções:
     * - up(): Adiciona as restrições de chave estrangeira aos campos acima, garantindo integridade referencial.
     *   Todas as chaves estrangeiras possuem as ações 'CASCADE' tanto para atualização quanto para deleção,
     *   ou seja, alterações ou remoções nas tabelas referenciadas serão refletidas automaticamente na tabela 'evaluation_criteria'.
     */
    public function up()
    {
        Schema::table('evaluation_criteria', function (Blueprint $table) {
            $table->foreign(['id_member'], 'evaluation_criteria_ibfk_3')->references(['id_members'])->on('members')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_paper'], 'evaluation_criteria_ibfk_2')->references(['id_paper'])->on('papers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_criteria'], 'evaluation_criteria_ibfk_1')->references(['id_criteria'])->on('criteria')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluation_criteria', function (Blueprint $table) {
            $table->dropForeign('evaluation_criteria_ibfk_3');
            $table->dropForeign('evaluation_criteria_ibfk_2');
            $table->dropForeign('evaluation_criteria_ibfk_1');
        });
    }
};
