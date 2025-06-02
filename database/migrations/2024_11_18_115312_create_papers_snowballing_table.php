<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para criar a tabela 'papers_snowballing'.
     *
     * Esta migration cria a tabela 'papers_snowballing', utilizada para armazenar informações sobre artigos relacionados ao processo de snowballing em revisões sistemáticas.
     * 
     * Campos principais:
     * - id: Identificador único da tabela.
     * - paper_reference_id: Referência opcional para o id_paper da tabela 'papers'. Possui chave estrangeira com deleção em cascata para null.
     * - parent_snowballing_id: Referência opcional para outro registro da própria tabela 'papers_snowballing', permitindo relacionamentos hierárquicos. Chave estrangeira adicionada separadamente com deleção em cascata.
     * - doi, title, authors, year, abstract, keywords, type, bib_key, url, type_snowballing: Campos para armazenar metadados do artigo.
     * - is_duplicate: Indica se o artigo é duplicado.
     * - is_relevant: Indica se o artigo é relevante.
     * - timestamps: Campos automáticos de criação e atualização.
     *
     * Métodos utilizados:
     * - Schema::create(): Cria a tabela especificada com as colunas e restrições definidas.
     * - $table->id(): Cria uma coluna de chave primária auto-incrementada.
     * - $table->integer(), $table->unsignedBigInteger(), $table->string(), $table->year(), $table->text(), $table->boolean(): Definem os tipos de colunas da tabela.
     * - $table->foreign()->references()->on()->onDelete(): Define chaves estrangeiras e ações de deleção.
     * - Schema::table(): Permite modificar a tabela após sua criação, neste caso para adicionar uma chave estrangeira auto-relacionada.
     */
    public function up()
    {
        // Criar a tabela sem a chave estrangeira
        Schema::create('papers_snowballing', function (Blueprint $table) {
            $table->id();
            $table->integer('paper_reference_id')->nullable();
            $table->foreign('paper_reference_id')->references('id_paper')->on('papers')->onDelete('set null');
            $table->unsignedBigInteger('parent_snowballing_id')->nullable(); // Apenas definir a coluna

            $table->string('doi')->nullable();
            $table->string('title');
            $table->string('authors')->nullable();
            $table->year('year')->nullable();
            $table->text('abstract')->nullable();
            $table->text('keywords')->nullable();
            $table->string('type')->nullable();
            $table->string('bib_key')->nullable();
            $table->string('url')->nullable();
            $table->string('type_snowballing')->nullable();
            $table->boolean('is_duplicate')->default(false);
            $table->boolean('is_relevant')->nullable();
            $table->timestamps();
        });

        // Adicionar a chave estrangeira separadamente
        Schema::table('papers_snowballing', function (Blueprint $table) {
            $table->foreign('parent_snowballing_id')->references('id')->on('papers_snowballing')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('papers_snowballing', function (Blueprint $table) {
            $table->dropForeign(['parent_snowballing_id']);
        });

        Schema::dropIfExists('papers_snowballing');
    }
};
