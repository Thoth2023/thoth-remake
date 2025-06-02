<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para criar a tabela 'papers'.
     *
     * Campos:
     * - id_paper: (integer, auto-increment) Identificador único do paper.
     * - id_bib: (integer, indexado) Referência à tabela de bibliografias.
     * - title: (string) Título do paper.
     * - author: (string) Autor(es) do paper.
     * - book_title: (string) Título do livro ou publicação.
     * - volume: (string) Volume da publicação.
     * - pages: (string) Páginas do paper.
     * - num_pages: (string) Número total de páginas.
     * - abstract: (text) Resumo do paper.
     * - keywords: (text) Palavras-chave associadas ao paper.
     * - doi: (string) Identificador DOI do paper.
     * - journal: (string) Nome do periódico.
     * - issn: (string) ISSN do periódico.
     * - location: (string) Local de publicação.
     * - isbn: (string) ISBN do livro.
     * - address: (string) Endereço da publicação.
     * - type: (string) Tipo de publicação (ex: artigo, capítulo, etc).
     * - bib_key: (string) Chave de referência bibliográfica.
     * - url: (string) URL para acesso ao paper.
     * - publisher: (string) Editora responsável pela publicação.
     * - year: (string) Ano de publicação.
     * - added_at: (timestamp) Data/hora de inserção do registro.
     * - update_at: (timestamp) Data/hora da última atualização do registro.
     * - data_base: (integer, indexado) Identificador do banco de dados de origem.
     * - id: (integer) Campo genérico de identificação.
     * - status_selection: (integer, indexado, default 3) Status do processo de seleção.
     * - check_status_selection: (boolean, default false) Indica se o status de seleção foi verificado.
     * - status_qa: (integer, indexado) Status do processo de quality assurance.
     * - id_gen_score: (integer, indexado) Identificador da pontuação geral.
     * - check_qa: (boolean) Indica se o quality assurance foi verificado.
     * - score: (float, precisão 10, escala 0) Pontuação atribuída ao paper.
     * - status_extraction: (integer, indexado, default 2) Status do processo de extração.
     * - note: (text) Notas adicionais sobre o paper.
     */
    public function up()
    {
        Schema::create('papers', function (Blueprint $table) {
            $table->integer('id_paper', true);
            $table->integer('id_bib')->index('id_bib');
            $table->string('title');
            $table->string('author');
            $table->string('book_title');
            $table->string('volume');
            $table->string('pages');
            $table->string('num_pages');
            $table->text('abstract');
            $table->text('keywords');
            $table->string('doi');
            $table->string('journal');
            $table->string('issn');
            $table->string('location');
            $table->string('isbn');
            $table->string('address');
            $table->string('type');
            $table->string('bib_key');
            $table->string('url');
            $table->string('publisher');
            $table->string('year');
            $table->timestamp('added_at')->useCurrent();
            $table->timestamp('update_at')->useCurrent();
            $table->integer('data_base')->index('data_base');
            $table->integer('id');
            $table->integer('status_selection')->default(3)->index('status_selection');
            $table->boolean('check_status_selection')->default(false);
            $table->integer('status_qa')->index('status_qa');
            $table->integer('id_gen_score')->index('id_gen_score');
            $table->boolean('check_qa');
            $table->float('score', 10, 0);
            $table->integer('status_extraction')->default(2)->index('status_extraction');
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
        Schema::dropIfExists('papers');
    }
};
