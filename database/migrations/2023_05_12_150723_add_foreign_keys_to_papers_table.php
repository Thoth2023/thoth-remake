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
            $table->foreign(['status_selection'], 'papers_ibfk_4')->references(['id_status'])->on('status_selection')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['status_qa'], 'papers_ibfk_6')->references(['id_status'])->on('status_qa')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['status_extraction'], 'papers_ibfk_8')->references(['id_status'])->on('status_extraction')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['data_base'], 'papers_ibfk_3')->references(['id_database'])->on('data_base')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['status_qa'], 'papers_ibfk_5')->references(['id_status'])->on('status_qa')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_gen_score'], 'papers_ibfk_7')->references(['id_general_score'])->on('general_score')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_bib'], 'papers_ibfk_1')->references(['id_bib'])->on('bib_upload')->onUpdate('CASCADE')->onDelete('CASCADE');
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
            $table->dropForeign('papers_ibfk_4');
            $table->dropForeign('papers_ibfk_6');
            $table->dropForeign('papers_ibfk_8');
            $table->dropForeign('papers_ibfk_3');
            $table->dropForeign('papers_ibfk_5');
            $table->dropForeign('papers_ibfk_7');
            $table->dropForeign('papers_ibfk_1');
        });
    }
};
