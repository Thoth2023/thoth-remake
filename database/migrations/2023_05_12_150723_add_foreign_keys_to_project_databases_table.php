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
        Schema::table('project_databases', function (Blueprint $table) {
            $table->foreign(['id_database'], 'project_databases_ibfk_2')->references(['id_database'])->on('data_base')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_project'], 'project_databases_ibfk_1')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_databases', function (Blueprint $table) {
            $table->dropForeign('project_databases_ibfk_2');
            $table->dropForeign('project_databases_ibfk_1');
        });
    }
};
