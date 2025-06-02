<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chaves estrangeiras à tabela 'evaluation_ex_op'.
     *
     * Campos afetados:
     * - id_qe: Referencia o campo 'id_de' da tabela 'question_extraction'. 
     *   - Restrição: 'evaluation_ex_op_ibfk_3'
     *   - Ações: CASCADE em update e delete.
     *
     * - id_paper: Referencia o campo 'id_paper' da tabela 'papers'.
     *   - Restrição: 'evaluation_ex_op_ibfk_2'
     *   - Ações: CASCADE em update e delete.
     *
     * - id_option: Referencia o campo 'id_option' da tabela 'options_extraction'.
     *   - Restrição: 'evaluation_ex_op_ibfk_1'
     *   - Ações: CASCADE em update e delete.
     *
     * Funções:
     * - up(): Adiciona as restrições de chave estrangeira acima à tabela 'evaluation_ex_op'.
     */
    public function up()
    {
        Schema::table('evaluation_ex_op', function (Blueprint $table) {
            $table->foreign(['id_qe'], 'evaluation_ex_op_ibfk_3')->references(['id_de'])->on('question_extraction')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_paper'], 'evaluation_ex_op_ibfk_2')->references(['id_paper'])->on('papers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_option'], 'evaluation_ex_op_ibfk_1')->references(['id_option'])->on('options_extraction')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluation_ex_op', function (Blueprint $table) {
            $table->dropForeign('evaluation_ex_op_ibfk_3');
            $table->dropForeign('evaluation_ex_op_ibfk_2');
            $table->dropForeign('evaluation_ex_op_ibfk_1');
        });
    }
};
