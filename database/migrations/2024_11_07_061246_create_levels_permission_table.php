<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para criar a tabela 'level_permission', que faz a associação entre níveis (levels) e permissões (permissions).
     *
     * Métodos utilizados:
     * - Schema::create(): Cria uma nova tabela no banco de dados.
     * - $table->integer(): Define uma coluna do tipo inteiro.
     * - $table->unsignedBigInteger(): Define uma coluna do tipo inteiro grande sem sinal.
     * - $table->foreign(): Define uma chave estrangeira para garantir integridade referencial.
     * - onDelete('cascade'): Garante que, ao deletar um registro relacionado, os registros associados também sejam removidos.
     * - $table->primary(): Define uma chave primária composta para a tabela.
     *
     * Esta migration garante que cada combinação de nível e permissão seja única e mantém a integridade referencial entre as tabelas 'levels' e 'permissions'.
     */
    public function up()
    {
        Schema::create('level_permission', function (Blueprint $table) {
            // Defina level_id como integer e unsigned para ser compatível com id_level na tabela levels
            $table->integer('level_id');
            $table->unsignedBigInteger('permission_id');

            // Defina as chaves estrangeiras com o tipo correto
            $table->foreign('level_id')->references('id_level')->on('levels')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

            // Define a chave primária composta
            $table->primary(['level_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levels_permission');
    }
};
