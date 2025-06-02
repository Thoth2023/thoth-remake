<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration para criar a tabela 'evaluation_ex_txt'.
     *
     * Esta migration define a estrutura da tabela 'evaluation_ex_txt', que armazena textos de avaliação
     * associados a papéis e questões de avaliação.
     *
     * Campos:
     * - id_ev_txt: Identificador único do texto de avaliação (chave primária, auto-incremento).
     * - id_paper: Referência ao papel associado (indexado).
     * - id_qe: Referência à questão de avaliação associada (indexada).
     * - text: Texto da avaliação.
     */
    public function up()
    {
        Schema::create('evaluation_ex_txt', function (Blueprint $table) {
            $table->integer('id_ev_txt', true);
            $table->integer('id_paper')->index('id_paper');
            $table->integer('id_qe')->index('id_qe');
            $table->text('text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_ex_txt');
    }
};
