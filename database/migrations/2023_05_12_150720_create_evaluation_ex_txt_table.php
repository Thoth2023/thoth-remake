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
        Schema::create('evaluation_ex_txt', function (Blueprint $table) {
            $table->integer('id_ev_txt', true);
            $table->integer('id_paper')->index('id_paper');
            $table->integer('id_qe')->index('id_qe');
            $table->text('text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_ex_txt');
    }
};
