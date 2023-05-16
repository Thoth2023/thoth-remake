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
        Schema::create('project', function (Blueprint $table) {
            $table->integer('id_project', true);
            $table->unsignedBigInteger('id_user')->index('id_user');
            $table->string('title');
            $table->string('description');
            $table->string('objectives');
            $table->integer('created_by')->index('created_by');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('c_papers')->default(0);
            $table->float('planning', 10, 0)->default(0);
            $table->float('import', 10, 0)->default(0);
            $table->float('selection', 10, 0)->default(0);
            $table->float('quality', 10, 0)->default(0);
            $table->float('extraction', 10, 0)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project');
    }
};
