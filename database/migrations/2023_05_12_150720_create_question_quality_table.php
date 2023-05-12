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
        Schema::create('question_quality', function (Blueprint $table) {
            $table->integer('id_qa', true);
            $table->string('id');
            $table->string('description');
            $table->float('weight', 10, 0);
            $table->integer('min_to_app')->nullable()->index('question_quality_ibfk_2');
            $table->integer('id_project')->index('id_project');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_quality');
    }
};
