<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    /**
     * Migration para adicionar a coluna 'id_general_score' na tabela 'qa_cutoff' e remover a coluna 'score'.
     *
     * Métodos utilizados:
     * - Schema::table: Modifica a estrutura de uma tabela existente.
     * - $table->integer('id_general_score')->nullable()->after('id_project'): Adiciona uma nova coluna inteira, que pode ser nula, após a coluna 'id_project'.
     * - $table->foreign(['id_general_score'], 'id_general_score'): Define uma chave estrangeira para a coluna 'id_general_score' com o nome do índice 'id_general_score'.
     * - ->references('id_general_score'): Especifica a coluna referenciada na tabela estrangeira.
     * - ->on('general_score'): Define a tabela estrangeira como 'general_score'.
     * - ->onUpdate('CASCADE'): Atualiza automaticamente a coluna ao atualizar o valor referenciado.
     * - ->onDelete('CASCADE'): Remove automaticamente os registros relacionados ao deletar o valor referenciado.
     * - $table->dropColumn('score'): Remove a coluna 'score' da tabela 'qa_cutoff'.
     */
    public function up(): void
    {
        Schema::table('qa_cutoff', function (Blueprint $table) {
            $table->integer('id_general_score')->nullable()->after('id_project');
            $table->foreign(['id_general_score'], 'id_general_score')
                ->references('id_general_score')
                ->on('general_score')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->dropColumn('score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('qa_cutoff', function (Blueprint $table) {
            $table->dropForeign('id_general_score');
            $table->double('score')->default(0);
        });
    }
};
