<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Cria a tabela 'user_levels' para representar o relacionamento entre usuários e níveis.
     *
     * Esta migration define uma tabela de associação (pivot) entre as tabelas 'users' e 'levels',
     * permitindo que cada usuário possa ter múltiplos níveis e vice-versa.
     *
     * Métodos utilizados:
     * - Schema::create(): Cria uma nova tabela no banco de dados.
     * - $table->unsignedBigInteger('user_id'): Cria uma coluna do tipo inteiro sem sinal para armazenar o ID do usuário.
     * - $table->integer('level_id'): Cria uma coluna do tipo inteiro para armazenar o ID do nível.
     * - $table->foreign(): Define uma chave estrangeira para garantir a integridade referencial.
     *   - $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'): Relaciona 'user_id' à coluna 'id' da tabela 'users', removendo registros associados em caso de deleção.
     *   - $table->foreign('level_id')->references('id_level')->on('levels')->onDelete('cascade'): Relaciona 'level_id' à coluna 'id_level' da tabela 'levels', removendo registros associados em caso de deleção.
     * - $table->primary(['user_id', 'level_id']): Define uma chave primária composta pelas colunas 'user_id' e 'level_id'.
     * - $table->timestamps(): Adiciona as colunas 'created_at' e 'updated_at' para controle de data/hora.
     */
    public function up()
    {
        Schema::create('user_levels', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->integer('level_id');

            // Define foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('level_id')->references('id_level')->on('levels')->onDelete('cascade');

            // Define a chave primária composta
            $table->primary(['user_id', 'level_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_levels');
    }
};
