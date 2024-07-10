<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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
