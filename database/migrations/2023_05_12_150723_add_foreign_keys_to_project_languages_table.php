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
        Schema::table('project_languages', function (Blueprint $table) {
            $table->foreign(['id_language'], 'project_languages_ibfk_1')->references(['id_language'])->on('language')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_project'], 'project_languages_ibfk_2')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_languages', function (Blueprint $table) {
            $table->dropForeign('project_languages_ibfk_1');
            $table->dropForeign('project_languages_ibfk_2');
        });
    }
};
