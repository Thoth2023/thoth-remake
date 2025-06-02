<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chaves estrangeiras à tabela 'question_extraction'.
     *
     * Campos afetados:
     * - id_project: Referencia o campo 'id_project' da tabela 'project'.
     * - type: Referencia o campo 'id_type' da tabela 'types_question'.
     *
     * Funções:
     * - up(): Adiciona as restrições de chave estrangeira para os campos 'id_project' e 'type' na tabela 'question_extraction'.
     *   - A chave estrangeira 'question_extraction_ibfk_1' conecta 'id_project' à tabela 'project', com atualização e deleção em cascata.
     *   - A chave estrangeira 'question_extraction_ibfk_2' conecta 'type' à tabela 'types_question', também com atualização e deleção em cascata.
     */
    public function up()
    {
        Schema::table('question_extraction', function (Blueprint $table) {
            $table->foreign(['id_project'], 'question_extraction_ibfk_1')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['type'], 'question_extraction_ibfk_2')->references(['id_type'])->on('types_question')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question_extraction', function (Blueprint $table) {
            $table->dropForeign('question_extraction_ibfk_1');
            $table->dropForeign('question_extraction_ibfk_2');
        });
    }
};
