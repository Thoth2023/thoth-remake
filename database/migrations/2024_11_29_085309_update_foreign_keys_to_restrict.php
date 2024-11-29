<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Atualizar a tabela "papers"
        Schema::table('papers', function (Blueprint $table) {
            $table->dropForeign('papers_ibfk_4');
            $table->dropForeign('papers_ibfk_6');
            $table->dropForeign('papers_ibfk_8');
            $table->dropForeign('papers_ibfk_3');
            $table->dropForeign('papers_ibfk_5');
            $table->dropForeign('papers_ibfk_7');
            $table->dropForeign('papers_ibfk_1');

            $table->foreign('status_selection', 'papers_ibfk_4')->references('id_status')->on('status_selection')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('status_qa', 'papers_ibfk_6')->references('id_status')->on('status_qa')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('status_extraction', 'papers_ibfk_8')->references('id_status')->on('status_extraction')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('data_base', 'papers_ibfk_3')->references('id_database')->on('data_base')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('id_gen_score', 'papers_ibfk_7')->references('id_general_score')->on('general_score')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('id_bib', 'papers_ibfk_1')->references('id_bib')->on('bib_upload')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        // Atualizar a tabela "papers_qa"
        Schema::table('papers_qa', function (Blueprint $table) {
            $table->dropForeign('papers_qa_ibfk_3');
            $table->dropForeign('papers_qa_ibfk_2');
            $table->dropForeign('papers_qa_ibfk_4');
            $table->dropForeign('papers_qa_ibfk_1');

            $table->foreign('id_gen_score', 'papers_qa_ibfk_3')->references('id_general_score')->on('general_score')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('id_paper', 'papers_qa_ibfk_2')->references('id_paper')->on('papers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('id_status', 'papers_qa_ibfk_4')->references('id_status')->on('status_qa')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('id_member', 'papers_qa_ibfk_1')->references('id_members')->on('members')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        // Atualizar a tabela "evaluation_qa"
        Schema::table('evaluation_qa', function (Blueprint $table) {
            $table->dropForeign('evaluation_qa_ibfk_3');
            $table->dropForeign('evaluation_qa_ibfk_2');
            $table->dropForeign('evaluation_qa_ibfk_4');
            $table->dropForeign('evaluation_qa_ibfk_1');

            $table->foreign('id_score_qa', 'evaluation_qa_ibfk_3')->references('id_score')->on('score_quality')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('id_qa', 'evaluation_qa_ibfk_2')->references('id_qa')->on('question_quality')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('id_paper', 'evaluation_qa_ibfk_4')->references('id_paper')->on('papers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('id_member', 'evaluation_qa_ibfk_1')->references('id_members')->on('members')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
        // Atualizar a tabela "papers_selection"
        Schema::table('papers_selection', function (Blueprint $table) {
            // Remover constraints existentes
            $table->dropForeign('papers_selection_ibfk_3');
            $table->dropForeign('papers_selection_ibfk_2');
            $table->dropForeign('papers_selection_ibfk_1');

            // Recriar constraints com comportamento RESTRICT
            $table->foreign('id_paper', 'papers_selection_ibfk_3')->references('id_paper')->on('papers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('id_status', 'papers_selection_ibfk_2')->references('id_status')->on('status_selection')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->foreign('id_member', 'papers_selection_ibfk_1')->references('id_members')->on('members')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Reverter as mudanças para "CASCADE"
        Schema::table('papers', function (Blueprint $table) {
            $table->dropForeign('papers_ibfk_4');
            $table->dropForeign('papers_ibfk_6');
            $table->dropForeign('papers_ibfk_8');
            $table->dropForeign('papers_ibfk_3');
            $table->dropForeign('papers_ibfk_5');
            $table->dropForeign('papers_ibfk_7');
            $table->dropForeign('papers_ibfk_1');

            $table->foreign('status_selection', 'papers_ibfk_4')->references('id_status')->on('status_selection')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('status_qa', 'papers_ibfk_6')->references('id_status')->on('status_qa')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('status_extraction', 'papers_ibfk_8')->references('id_status')->on('status_extraction')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('data_base', 'papers_ibfk_3')->references('id_database')->on('data_base')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('id_gen_score', 'papers_ibfk_7')->references('id_general_score')->on('general_score')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('id_bib', 'papers_ibfk_1')->references('id_bib')->on('bib_upload')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        Schema::table('papers_qa', function (Blueprint $table) {
            $table->dropForeign('papers_qa_ibfk_3');
            $table->dropForeign('papers_qa_ibfk_2');
            $table->dropForeign('papers_qa_ibfk_4');
            $table->dropForeign('papers_qa_ibfk_1');

            $table->foreign('id_gen_score', 'papers_qa_ibfk_3')->references('id_general_score')->on('general_score')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('id_paper', 'papers_qa_ibfk_2')->references('id_paper')->on('papers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('id_status', 'papers_qa_ibfk_4')->references('id_status')->on('status_qa')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('id_member', 'papers_qa_ibfk_1')->references('id_members')->on('members')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        Schema::table('evaluation_qa', function (Blueprint $table) {
            $table->dropForeign('evaluation_qa_ibfk_3');
            $table->dropForeign('evaluation_qa_ibfk_2');
            $table->dropForeign('evaluation_qa_ibfk_4');
            $table->dropForeign('evaluation_qa_ibfk_1');

            $table->foreign('id_score_qa', 'evaluation_qa_ibfk_3')->references('id_score')->on('score_quality')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('id_qa', 'evaluation_qa_ibfk_2')->references('id_qa')->on('question_quality')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('id_paper', 'evaluation_qa_ibfk_4')->references('id_paper')->on('papers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('id_member', 'evaluation_qa_ibfk_1')->references('id_members')->on('members')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        // Reverter as mudanças na tabela "papers_selection"
        Schema::table('papers_selection', function (Blueprint $table) {
            $table->dropForeign('papers_selection_ibfk_3');
            $table->dropForeign('papers_selection_ibfk_2');
            $table->dropForeign('papers_selection_ibfk_1');

            // Restaurar constraints com CASCADE
            $table->foreign('id_paper', 'papers_selection_ibfk_3')->references('id_paper')->on('papers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('id_status', 'papers_selection_ibfk_2')->references('id_status')->on('status_selection')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('id_member', 'papers_selection_ibfk_1')->references('id_members')->on('members')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }
};
