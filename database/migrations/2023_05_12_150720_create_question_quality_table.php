<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para criar a tabela 'question_quality'.
     *
     * Campos:
     * - id_qa: inteiro, chave primária auto-incrementada. Identificador único da qualidade da questão.
     * - id: string. Identificador da qualidade da questão (pode ser um código ou slug).
     * - description: string. Descrição textual da qualidade da questão.
     * - weight: float(10,0). Peso atribuído à qualidade da questão, utilizado para cálculos ou avaliações.
     * - min_to_app: inteiro, opcional (nullable). Valor mínimo para aplicação da qualidade; possui índice para otimizar buscas. 
     * - id_project: inteiro. Identificador do projeto relacionado; possui índice para otimizar buscas.
     */
    public function up()
    {
        Schema::create('question_quality', function (Blueprint $table) {
            $table->integer('id_qa', true);
            $table->string('id');
            $table->string('description');
            $table->float('weight', 10, 0);
            $table->integer('min_to_app')->nullable()->index('question_quality_ibfk_2');
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
        Schema::dropIfExists('question_quality');
    }
};
