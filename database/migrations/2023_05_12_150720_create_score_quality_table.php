<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Cria a tabela 'score_quality' para armazenar informações relacionadas à qualidade de pontuação.
     *
     * Campos:
     * - id_score: Identificador único da pontuação (chave primária, auto-incremento).
     * - score_rule: Regra utilizada para calcular ou atribuir a pontuação.
     * - description: Descrição detalhada da regra ou do critério de pontuação.
     * - score: Valor numérico da pontuação atribuída.
     * - id_qa: Identificador relacionado à tabela de qualidade (provavelmente uma chave estrangeira), indexado para otimizar buscas.
     */
    public function up()
    {
        Schema::create('score_quality', function (Blueprint $table) {
            $table->integer('id_score', true);
            $table->string('score_rule');
            $table->string('description');
            $table->integer('score');
            $table->integer('id_qa')->index('id_qa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score_quality');
    }
};
