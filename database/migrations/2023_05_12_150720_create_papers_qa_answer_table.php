<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration para criar a tabela 'papers_qa_answer'.
     *
     * Esta migration define a estrutura da tabela 'papers_qa_answer', que armazena as respostas
     * associadas a perguntas em um determinado paper.
     * Campos:
     * - id_papers_qa_answer: Chave primária, auto-incremento.
     * - id_paper: Referência ao paper associado (com índice).
     * - id_question: Referência à pergunta associada (com índice).
     * - id_answer: Referência à resposta associada (com índice).
     */
    public function up()
    {
        Schema::create('papers_qa_answer', function (Blueprint $table) {
            $table->integer('id_papers_qa_answer', true);
            $table->integer('id_paper')->index('id_paper');
            $table->integer('id_question')->index('id_question');
            $table->integer('id_answer')->index('id_answer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('papers_qa_answer');
    }
};
