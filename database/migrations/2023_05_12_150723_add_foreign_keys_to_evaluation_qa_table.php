<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chaves estrangeiras à tabela 'evaluation_qa'.
     *
     * Campos afetados:
     * - id_score_qa: Referencia o campo 'id_score' da tabela 'score_quality'.
     * - id_qa: Referencia o campo 'id_qa' da tabela 'question_quality'.
     * - id_paper: Referencia o campo 'id_paper' da tabela 'papers'.
     * - id_member: Referencia o campo 'id_members' da tabela 'members'.
     *
     * Todas as chaves estrangeiras possuem as ações 'CASCADE' tanto para atualização quanto para deleção,
     * garantindo que alterações ou remoções nas tabelas referenciadas sejam refletidas automaticamente na tabela 'evaluation_qa'.
     *
     * Funções:
     * - up(): Adiciona as chaves estrangeiras à tabela 'evaluation_qa' conforme descrito acima.
     */
    public function up()
    {
        Schema::table('evaluation_qa', function (Blueprint $table) {
            $table->foreign(['id_score_qa'], 'evaluation_qa_ibfk_3')->references(['id_score'])->on('score_quality')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_qa'], 'evaluation_qa_ibfk_2')->references(['id_qa'])->on('question_quality')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_paper'], 'evaluation_qa_ibfk_4')->references(['id_paper'])->on('papers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_member'], 'evaluation_qa_ibfk_1')->references(['id_members'])->on('members')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluation_qa', function (Blueprint $table) {
            $table->dropForeign('evaluation_qa_ibfk_3');
            $table->dropForeign('evaluation_qa_ibfk_2');
            $table->dropForeign('evaluation_qa_ibfk_4');
            $table->dropForeign('evaluation_qa_ibfk_1');
        });
    }
};
