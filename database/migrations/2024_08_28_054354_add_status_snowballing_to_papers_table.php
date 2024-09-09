<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('papers', function (Blueprint $table) {
            // Adiciona a coluna status_snowballing após status_extraction
            $table->unsignedBigInteger('status_snowballing')
                ->default(4)
                ->after('status_extraction');

            // Define a chave estrangeira para a tabela status_snowballing
            $table->foreign('status_snowballing')
                ->references('id')
                ->on('status_snowballing')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('papers', function (Blueprint $table) {
            // Remove a chave estrangeira
            $table->dropForeign(['status_snowballing']);

            // Remove a coluna status_snowballing
            $table->dropColumn('status_snowballing');
        });
    }
};
