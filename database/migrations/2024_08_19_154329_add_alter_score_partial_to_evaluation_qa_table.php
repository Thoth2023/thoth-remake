<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para adicionar a coluna 'score_partial' na tabela 'evaluation_qa'.
     *
     * Esta migration adiciona uma nova coluna do tipo double chamada 'score_partial'
     * após a coluna 'id_score_qa', com valor padrão igual a 0.
     *
     * Métodos utilizados:
     * - up(): Executa as alterações na tabela, utilizando o método Schema::table()
     *   para modificar a estrutura da tabela existente.
     *   - $table->double('score_partial')->after('id_score_qa')->default(0):
     *     Adiciona a coluna 'score_partial' do tipo double, posicionada após 'id_score_qa'
     *     e define o valor padrão como 0.
     */
    public function up(): void
    {
        Schema::table('evaluation_qa', function (Blueprint $table) {
            $table->double('score_partial')->after('id_score_qa')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluation_qa', function (Blueprint $table) {
            $table->dropColumn('score_partial');
        });
    }
};
