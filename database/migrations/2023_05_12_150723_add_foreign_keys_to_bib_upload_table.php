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
        Schema::table('bib_upload', function (Blueprint $table) {
            $table->foreign(['id_project_database'], 'bib_upload_ibfk_1')->references(['id_project_database'])->on('project_databases')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bib_upload', function (Blueprint $table) {
            $table->dropForeign('bib_upload_ibfk_1');
        });
    }
};
