<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chaves estrangeiras à tabela 'evaluation_ex_txt'.
     *
     * Campos afetados:
     * - id_qe: Adiciona uma chave estrangeira referenciando o campo 'id_de' da tabela 'question_extraction'.
     * - id_paper: Adiciona uma chave estrangeira referenciando o campo 'id_paper' da tabela 'papers', 
     *   com atualização e remoção em cascata.
     *
     * Funções:
     * - up(): Aplica as restrições de chave estrangeira aos campos especificados na tabela 'evaluation_ex_txt'.
     */
    public function up()
    {
        Schema::table('evaluation_ex_txt', function (Blueprint $table) {
            $table->foreign(['id_qe'], 'evaluation_ex_txt_ibfk_2')->references(['id_de'])->on('question_extraction');
            $table->foreign(['id_paper'], 'evaluation_ex_txt_ibfk_1')->references(['id_paper'])->on('papers')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluation_ex_txt', function (Blueprint $table) {
            $table->dropForeign('evaluation_ex_txt_ibfk_2');
            $table->dropForeign('evaluation_ex_txt_ibfk_1');
        });
    }
};
