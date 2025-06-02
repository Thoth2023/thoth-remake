<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    /**
     * Migration para adicionar a coluna 'rule' na tabela 'criteria'.
     *
     * Esta migration altera a tabela existente 'criteria', incluindo uma nova coluna do tipo string chamada 'rule',
     * que recebe o valor padrão 'ALL'. Esta coluna pode ser utilizada para armazenar regras específicas associadas
     * aos critérios.
     *
     * Métodos utilizados:
     * - up(): Executa as alterações na tabela, adicionando a coluna 'rule' com valor padrão.
     *   - Schema::table(): Permite modificar uma tabela existente no banco de dados.
     *   - $table->string('rule')->default('ALL'): Adiciona uma nova coluna do tipo string chamada 'rule' com valor padrão 'ALL'.
     */
    public function up(): void
    {
        Schema::table('criteria', function (Blueprint $table) {
            $table->string('rule')->default('ALL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('criteria', function (Blueprint $table) {
            $table->dropColumn('rule');
        });
    }
};
