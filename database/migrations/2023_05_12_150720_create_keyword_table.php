<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela 'keyword' no banco de dados.
     *
     * Esta migration define a estrutura da tabela 'keyword', que armazena palavras-chave associadas a projetos.
     *
     * Campos:
     * - id_keyword: Identificador único da palavra-chave (chave primária, auto-incremento).
     * - description: Descrição da palavra-chave.
     * - id_project: Referência ao projeto relacionado (indexado).
     */
    public function up()
    {
        Schema::create('keyword', function (Blueprint $table) {
            $table->integer('id_keyword', true);
            $table->string('description');
            $table->integer('id_project')->index('id_project');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keyword');
    }
};
