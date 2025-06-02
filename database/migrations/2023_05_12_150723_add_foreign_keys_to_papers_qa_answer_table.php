<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chaves estrangeiras à tabela 'papers_qa_answer'.
     *
     * Campos afetados:
     * - id_question: Cria uma chave estrangeira (papers_qa_answer_ibfk_3) referenciando o campo 'id_qa' da tabela 'question_quality'.
     *   - Atualizações e deleções em 'question_quality' são propagadas em cascata.
     * - id_answer: Cria uma chave estrangeira (papers_qa_answer_ibfk_2) referenciando o campo 'id_score' da tabela 'score_quality'.
     *   - Não há ação definida para update/delete.
     * - id_paper: Cria uma chave estrangeira (papers_qa_answer_ibfk_1) referenciando o campo 'id_paper' da tabela 'papers'.
     *   - Atualizações e deleções em 'papers' são propagadas em cascata.
     *
     * Funções:
     * - up(): Adiciona as chaves estrangeiras acima à tabela 'papers_qa_answer', garantindo integridade referencial entre as tabelas relacionadas.
     */
    public function up()
    {
        Schema::table('papers_qa_answer', function (Blueprint $table) {
            $table->foreign(['id_question'], 'papers_qa_answer_ibfk_3')->references(['id_qa'])->on('question_quality')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_answer'], 'papers_qa_answer_ibfk_2')->references(['id_score'])->on('score_quality');
            $table->foreign(['id_paper'], 'papers_qa_answer_ibfk_1')->references(['id_paper'])->on('papers')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('papers_qa_answer', function (Blueprint $table) {
            $table->dropForeign('papers_qa_answer_ibfk_3');
            $table->dropForeign('papers_qa_answer_ibfk_2');
            $table->dropForeign('papers_qa_answer_ibfk_1');
        });
    }
};
