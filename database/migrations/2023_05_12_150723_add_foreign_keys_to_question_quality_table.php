<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chaves estrangeiras à tabela 'question_quality'.
     *
     * Campos afetados:
     * - id_project: Adiciona uma chave estrangeira referenciando o campo 'id_project' da tabela 'project'.
     *   - Atualizações e deleções em 'project' são propagadas em cascata para 'question_quality'.
     * - min_to_app: Adiciona uma chave estrangeira referenciando o campo 'id_score' da tabela 'score_quality'.
     *   - Atualizações e deleções em 'score_quality' definem o valor como NULL em 'question_quality'.
     *
     * Funções:
     * - up(): Aplica as alterações na tabela, criando as chaves estrangeiras conforme descrito acima.
     */
    public function up()
    {
        Schema::table('question_quality', function (Blueprint $table) {
            $table->foreign(['id_project'], 'question_quality_ibfk_1')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['min_to_app'], 'question_quality_ibfk_2')->references(['id_score'])->on('score_quality')->onUpdate('SET NULL')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question_quality', function (Blueprint $table) {
            $table->dropForeign('question_quality_ibfk_1');
            $table->dropForeign('question_quality_ibfk_2');
        });
    }
};
