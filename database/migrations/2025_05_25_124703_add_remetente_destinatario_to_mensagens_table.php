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
        Schema::table('mensagens', function (Blueprint $table) {
            $table->unsignedBigInteger('remetente_id')->nullable()->after('id');
            $table->unsignedBigInteger('destinatario_id')->nullable()->after('remetente_id');
        });
    }

    public function down()
    {
        Schema::table('mensagens', function (Blueprint $table) {
            $table->dropColumn(['remetente_id', 'destinatario_id']);
        });
    }
};
