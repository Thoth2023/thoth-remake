<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Cria a tabela 'evaluation_criteria' para armazenar os critérios de avaliação associados a cada artigo, critério e membro avaliador.
     *
     * Estrutura da tabela:
     * - id_evaluation_criteria: Identificador único da avaliação do critério (chave primária, auto-incremento).
     * - id_paper: Referência ao artigo avaliado (indexado).
     * - id_criteria: Referência ao critério de avaliação (indexado).
     * - id_member: Referência ao membro avaliador (indexado).
     *
     * Esta migration facilita o relacionamento entre artigos, critérios de avaliação e membros responsáveis pela avaliação.
     */
    public function up()
    {
        Schema::create('evaluation_criteria', function (Blueprint $table) {
            $table->integer('id_evaluation_criteria', true);
            $table->integer('id_paper')->index('id_paper');
            $table->integer('id_criteria')->index('id_criteria');
            $table->integer('id_member')->index('id_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_criteria');
    }
};
