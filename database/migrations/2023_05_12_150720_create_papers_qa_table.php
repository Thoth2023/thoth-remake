<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration para criar a tabela 'papers_qa'.
     *
     * Esta migration define a estrutura da tabela 'papers_qa', que armazena informações sobre
     * perguntas e respostas associadas a papers, incluindo notas e pontuações.
     * Campos:
     * - id_paper_qa: Chave primária, auto-incremento.
     * - id_paper: Referência ao paper associado (com índice).
     * - id_member: Referência ao membro associado (com índice).
     * - id_gen_score: Referência à pontuação geral associada (com índice).
     * - id_status: Referência ao status associado (com índice).
     * - note: Texto contendo notas adicionais.
     * - score: Pontuação atribuída, do tipo float.
     */
    public function up()
    {
        Schema::create('papers_qa', function (Blueprint $table) {
            $table->integer('id_paper_qa', true);
            $table->integer('id_paper')->index('id_paper');
            $table->integer('id_member')->index('id_member');
            $table->integer('id_gen_score')->index('id_gen_score');
            $table->integer('id_status')->index('id_status');
            $table->text('note');
            $table->float('score', 10, 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('papers_qa');
    }
};
