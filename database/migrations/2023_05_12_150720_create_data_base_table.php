<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    /**
     * Migration para criar a tabela 'data_base'.
     *
     * Esta migration define a estrutura da tabela 'data_base', que armazena informações sobre bases de dados,
     * incluindo um identificador único, nome, link e estado atual da base.
     *
     * Campos:
     * - id_database: Identificador único da base de dados (chave primária, auto-incremento).
     * - name: Nome da base de dados.
     * - link: URL ou referência para a base de dados.
     * - state: Estado da base de dados (padrão: 'proposed').
     */
    public function up()
    {
        Schema::create('data_base', function (Blueprint $table) {
            $table->integer('id_database', true);
            $table->string('name');
            $table->string('link');

            $table->string('state')->default('proposed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_base');
    }
};
