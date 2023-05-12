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
        Schema::create('evaluation_ex_op', function (Blueprint $table) {
            $table->integer('ev_ex_op', true);
            $table->integer('id_paper')->index('id_paper');
            $table->integer('id_qe')->index('id_qe');
            $table->integer('id_option')->nullable()->index('id_option');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_ex_op');
    }
};
