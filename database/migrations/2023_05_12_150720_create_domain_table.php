<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Migration para criar a tabela 'domain'.
     *
     * Esta migration define a estrutura da tabela 'domain', que armazena domínios relacionados a projetos.
     * Campos:
     * - id_domain: identificador único do domínio (chave primária, auto-incremento).
     * - description: descrição do domínio.
     * - id_project: referência ao projeto associado (com índice para otimizar buscas).
     */
    public function up()
    {
        Schema::create('domain', function (Blueprint $table) {
            $table->integer('id_domain', true);
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
        Schema::dropIfExists('domain');
    }
};
