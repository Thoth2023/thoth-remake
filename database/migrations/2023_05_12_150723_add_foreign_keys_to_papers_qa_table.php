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
        Schema::table('papers_qa', function (Blueprint $table) {
            $table->foreign(['id_gen_score'], 'papers_qa_ibfk_3')->references(['id_general_score'])->on('general_score')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_paper'], 'papers_qa_ibfk_2')->references(['id_paper'])->on('papers')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_status'], 'papers_qa_ibfk_4')->references(['id_status'])->on('status_qa')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_member'], 'papers_qa_ibfk_1')->references(['id_members'])->on('members')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('papers_qa', function (Blueprint $table) {
            $table->dropForeign('papers_qa_ibfk_3');
            $table->dropForeign('papers_qa_ibfk_2');
            $table->dropForeign('papers_qa_ibfk_4');
            $table->dropForeign('papers_qa_ibfk_1');
        });
    }
};
