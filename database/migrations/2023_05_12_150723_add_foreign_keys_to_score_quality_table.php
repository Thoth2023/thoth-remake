<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar chave estrangeira à tabela 'score_quality'.
     *
     * Campos afetados:
     * - id_qa: Campo que receberá a chave estrangeira, referenciando o campo 'id_qa' da tabela 'question_quality'.
     *
     * Funções:
     * - up(): Adiciona a restrição de chave estrangeira 'score_quality_ibfk_1' ao campo 'id_qa', 
     *         referenciando 'id_qa' na tabela 'question_quality'. Define as ações ON UPDATE e ON DELETE como CASCADE.
     */
    public function up()
    {
        Schema::table('score_quality', function (Blueprint $table) {
            $table->foreign(['id_qa'], 'score_quality_ibfk_1')->references(['id_qa'])->on('question_quality')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('score_quality', function (Blueprint $table) {
            $table->dropForeign('score_quality_ibfk_1');
        });
    }
};
