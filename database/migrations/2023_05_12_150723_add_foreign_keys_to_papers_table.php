<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chaves estrangeiras à tabela 'papers'.
     *
     * Esta migration define as relações entre a tabela 'papers' e outras tabelas do banco de dados,
     * garantindo integridade referencial e aplicando ações em cascata para atualização e exclusão.
     *
     * Campos e relações adicionadas:
     * - status_selection: Referencia 'id_status' na tabela 'status_selection' (CASCADE em update/delete).
     * - status_qa: Referencia 'id_status' na tabela 'status_qa' (CASCADE em update/delete). 
     *   Observação: Existem duas foreign keys para 'status_qa' ('papers_ibfk_5' e 'papers_ibfk_6').
     * - status_extraction: Referencia 'id_status' na tabela 'status_extraction' (CASCADE em update/delete).
     * - data_base: Referencia 'id_database' na tabela 'data_base' (CASCADE em update/delete).
     * - id_gen_score: Referencia 'id_general_score' na tabela 'general_score' (CASCADE em update/delete).
     * - id_bib: Referencia 'id_bib' na tabela 'bib_upload' (CASCADE em update/delete).
     *
     * Funções:
     * - up(): Adiciona as chaves estrangeiras acima à tabela 'papers', configurando as ações em cascata.
     */
    public function up()
    {
        Schema::table('papers', function (Blueprint $table) {
            $table->foreign(['status_selection'], 'papers_ibfk_4')->references(['id_status'])->on('status_selection')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['status_qa'], 'papers_ibfk_6')->references(['id_status'])->on('status_qa')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['status_extraction'], 'papers_ibfk_8')->references(['id_status'])->on('status_extraction')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['data_base'], 'papers_ibfk_3')->references(['id_database'])->on('data_base')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['status_qa'], 'papers_ibfk_5')->references(['id_status'])->on('status_qa')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_gen_score'], 'papers_ibfk_7')->references(['id_general_score'])->on('general_score')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_bib'], 'papers_ibfk_1')->references(['id_bib'])->on('bib_upload')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('papers', function (Blueprint $table) {
            $table->dropForeign('papers_ibfk_4');
            $table->dropForeign('papers_ibfk_6');
            $table->dropForeign('papers_ibfk_8');
            $table->dropForeign('papers_ibfk_3');
            $table->dropForeign('papers_ibfk_5');
            $table->dropForeign('papers_ibfk_7');
            $table->dropForeign('papers_ibfk_1');
        });
    }
};
