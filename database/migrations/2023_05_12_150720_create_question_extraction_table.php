<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Cria a tabela 'question_extraction' no banco de dados.
     *
     * Campos:
     * - id_de: inteiro, chave primária auto-incrementada. Identificador único da extração de questão.
     * - id: string. Identificador da questão extraída.
     * - description: string. Descrição da questão extraída.
     * - type: inteiro, indexado. Tipo da questão extraída (pode representar categorias ou classificações).
     * - id_project: inteiro, indexado. Identificador do projeto ao qual a questão extraída pertence.
     */
    public function up()
    {
        Schema::create('question_extraction', function (Blueprint $table) {
            $table->integer('id_de', true);
            $table->string('id');
            $table->string('description');
            $table->integer('type')->index('type');
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
        Schema::dropIfExists('question_extraction');
    }
};
