<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Migration para criar a tabela 'module'.
     *
     * Esta migration define a estrutura da tabela 'module' no banco de dados,
     * incluindo os seguintes campos:
     * - id_module: inteiro, chave primária, auto-incremento.
     * - description: string, descrição do módulo.
     *
     * Utilizada para armazenar informações sobre os módulos do sistema.
     */
    public function up()
    {
        Schema::create('module', function (Blueprint $table) {
            $table->integer('id_module', true);
            $table->string('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module');
    }
};
