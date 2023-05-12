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
        Schema::create('papers_selection', function (Blueprint $table) {
            $table->integer('id_paper_sel', true);
            $table->integer('id_member')->index('id_user');
            $table->integer('id_paper')->index('id_paper');
            $table->integer('id_status')->index('id_status');
            $table->text('note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('papers_selection');
    }
};
