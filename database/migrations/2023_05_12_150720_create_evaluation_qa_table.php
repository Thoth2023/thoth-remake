<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration para criar a tabela 'evaluation_qa'.
     *
     * Esta migration define a estrutura da tabela 'evaluation_qa', que armazena avaliações de perguntas e respostas
     * associadas a membros e papéis específicos.
     *
     * Campos:
     * - id_ev_qa: Identificador único da avaliação (chave primária, auto-incremento).
     * - id_qa: Referência à pergunta e resposta avaliada (indexado).
     * - id_member: Referência ao membro que realizou a avaliação (indexado).
     * - id_score_qa: Referência à pontuação atribuída à pergunta e resposta (indexado).
     * - id_paper: Referência ao papel associado à avaliação (indexado).
     */
    public function up()
    {
        Schema::create('evaluation_qa', function (Blueprint $table) {
            $table->integer('id_ev_qa', true);
            $table->integer('id_qa')->index('id_qa');
            $table->integer('id_member')->index('id_member');
            $table->integer('id_score_qa')->index('id_score_qa');
            $table->integer('id_paper')->index('id_paper');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_qa');
    }
};
