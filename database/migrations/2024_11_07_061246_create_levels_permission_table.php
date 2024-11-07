<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
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
