<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration para criar a tabela 'research_question'.
     *
     * Esta migration define a estrutura da tabela 'research_question', que armazena perguntas de pesquisa
     * associadas a um determinado projeto.
     * Campos:
     * - id_research_question: Chave primária, auto-incremento.
     * - id: Identificador único da pergunta de pesquisa.
     * - description: Descrição da pergunta de pesquisa.
     * - id_project: Referência ao projeto associado (com índice).
     */
    public function up()
    {
        Schema::create('research_question', function (Blueprint $table) {
            $table->integer('id_research_question', true);
            $table->string('id');
            $table->string('description');
            $table->integer('id_project')->index('id_project');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('research_question');
    }
};
