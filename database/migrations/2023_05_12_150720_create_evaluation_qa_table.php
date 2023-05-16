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
        Schema::create('evaluation_qa', function (Blueprint $table) {
            $table->integer('id_ev_qa', true);
            $table->integer('id_qa')->index('id_qa');
            $table->integer('id_member')->index('id_member');
            $table->integer('id_score_qa')->index('id_score_qa');
            $table->integer('id_paper')->index('id_paper');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_qa');
    }
};
