<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration para criar a tabela 'papers_selection'.
     *
     * Esta migration define a estrutura da tabela 'papers_selection', que armazena informações sobre
     * a seleção de papers por membros, incluindo notas e status.
     * Campos:
     * - id_paper_sel: Chave primária, auto-incremento.
     * - id_member: Referência ao membro associado (com índice).
     * - id_paper: Referência ao paper associado (com índice).
     * - id_status: Referência ao status da seleção (com índice).
     * - note: Texto contendo notas adicionais sobre a seleção.
     */
    public function up()
    {
        Schema::create('papers_selection', function (Blueprint $table) {
            $table->integer('id_paper_sel', true);
            $table->integer('id_member')->index('id_user');
            $table->integer('id_paper')->index('id_paper');
            $table->integer('id_status')->index('id_status');
            $table->text('note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('papers_selection');
    }
};
