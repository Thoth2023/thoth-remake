<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    /**
     * Migration para criar a tabela 'qa_cutoff'.
     *
     * Métodos utilizados:
     * - Schema::create: Cria uma nova tabela no banco de dados.
     * - $table->id('id_cutoff'): Cria uma coluna de chave primária auto-incrementada chamada 'id_cutoff'.
     * - $table->integer('id_project')->index('id_project'): Cria uma coluna inteira 'id_project' e adiciona um índice com o nome 'id_project'.
     * - $table->double('score')->default(0): Cria uma coluna do tipo double chamada 'score' com valor padrão 0.
     *
     * Esta migration é responsável por armazenar os valores de cutoff de QA associados a projetos.
     */
    public function up(): void
    {
        Schema::create('qa_cutoff', function (Blueprint $table) {
            $table->id('id_cutoff');
            $table->integer('id_project')->index('id_project');
            $table->double('score')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qa_cutoff');
    }
};
