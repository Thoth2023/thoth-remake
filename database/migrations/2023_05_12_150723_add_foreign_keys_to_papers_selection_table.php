<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chaves estrangeiras à tabela 'papers_selection'.
     *
     * Esta migration define as seguintes relações:
     * - 'id_paper': Referencia o campo 'id_paper' da tabela 'papers'. 
     *   Atualizações e deleções em 'papers' são propagadas em cascata.
     * - 'id_status': Referencia o campo 'id_status' da tabela 'status_selection'.
     *   Atualizações e deleções em 'status_selection' são propagadas em cascata.
     * - 'id_member': Referencia o campo 'id_members' da tabela 'members'.
     *   Atualizações e deleções em 'members' são propagadas em cascata.
     *
     * Funções:
     * - up(): Adiciona as chaves estrangeiras à tabela 'papers_selection' com as restrições de integridade referencial.
     */
    public function up()
    {
        Schema::table('papers_selection', function (Blueprint $table) {
            $table->foreign(['id_paper'], 'papers_selection_ibfk_3')->references(['id_paper'])->on('papers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_status'], 'papers_selection_ibfk_2')->references(['id_status'])->on('status_selection')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_member'], 'papers_selection_ibfk_1')->references(['id_members'])->on('members')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('papers_selection', function (Blueprint $table) {
            $table->dropForeign('papers_selection_ibfk_3');
            $table->dropForeign('papers_selection_ibfk_2');
            $table->dropForeign('papers_selection_ibfk_1');
        });
    }
};
