<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration para adicionar as colunas 'invitation_token' e 'status' à tabela 'members'.
     *
     * - up(): Adiciona a coluna 'invitation_token' (string, 255 caracteres, pode ser nula) após a coluna 'level',
     *   utilizada para armazenar o token de convite do membro.
     *   Adiciona também a coluna 'status' (enum: 'pending', 'accepted', 'declined', valor padrão 'pending')
     *   após a coluna 'invitation_token', utilizada para indicar o status do convite do membro.
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->string('invitation_token', 255)->nullable()->after('level'); // Adiciona coluna de token de convite
            $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending')->after('invitation_token'); // Adiciona coluna de status
        });
    }

    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn(['invitation_token', 'status']); // Remove as colunas adicionadas no up()
        });
    }
};
