<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration para criar a tabela 'evaluation_ex_op'.
     *
     * Esta migration define a estrutura da tabela 'evaluation_ex_op', que armazena informações
     * sobre as opções de avaliação de exercícios.
     *
     * Campos:
     * - ev_ex_op: Identificador único do registro (chave primária, auto-incremento).
     * - id_paper: Referência ao papel associado (indexado).
     * - id_qe: Referência à questão de avaliação (indexada).
     * - id_option: Referência à opção associada (pode ser nula, indexada).
     */
    public function up()
    {
        Schema::create('evaluation_ex_op', function (Blueprint $table) {
            $table->integer('ev_ex_op', true);
            $table->integer('id_paper')->index('id_paper');
            $table->integer('id_qe')->index('id_qe');
            $table->integer('id_option')->nullable()->index('id_option');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_ex_op');
    }
};
