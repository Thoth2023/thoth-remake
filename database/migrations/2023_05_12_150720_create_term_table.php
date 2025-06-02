<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    /**
     * Cria a tabela 'term' no banco de dados.
     *
     * Campos:
     * - id_term (integer, auto incremento): Identificador único do termo.
     * - description (string): Descrição do termo.
     * - id_project (integer, indexado): Referência ao projeto associado ao termo.
     */
    public function up()
    {
        Schema::create('term', function (Blueprint $table) {
            $table->integer('id_term', true);
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
        Schema::dropIfExists('term');
    }
};
