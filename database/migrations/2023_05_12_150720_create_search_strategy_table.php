<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para criar a tabela 'search_strategy'.
     *
     * Campos:
     * - id_search_strategy: inteiro, chave primária auto-incrementada. Identificador único da estratégia de busca.
     * - description: texto. Descrição detalhada da estratégia de busca.
     * - id_project: inteiro, indexado. Referência ao projeto associado à estratégia de busca.
     */
    public function up()
    {
        Schema::create('search_strategy', function (Blueprint $table) {
            $table->integer('id_search_strategy', true);
            $table->text('description');
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
        Schema::dropIfExists('search_strategy');
    }
};
