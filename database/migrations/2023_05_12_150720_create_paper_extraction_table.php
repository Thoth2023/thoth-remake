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
        Schema::create('paper_extraction', function (Blueprint $table) {
            $table->integer('id_paper_ex', true);
            $table->integer('id_paper')->index('id_paper');
            $table->integer('id_qe');
            $table->text('text');
            $table->integer('id_resposta')->nullable()->index('id_resposta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paper_extraction');
    }
};
