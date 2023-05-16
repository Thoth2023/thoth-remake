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
        Schema::create('papers', function (Blueprint $table) {
            $table->integer('id_paper', true);
            $table->integer('id_bib')->index('id_bib');
            $table->string('title');
            $table->string('author');
            $table->string('book_title');
            $table->string('volume');
            $table->string('pages');
            $table->string('num_pages');
            $table->text('abstract');
            $table->text('keywords');
            $table->string('doi');
            $table->string('journal');
            $table->string('issn');
            $table->string('location');
            $table->string('isbn');
            $table->string('address');
            $table->string('type');
            $table->string('bib_key');
            $table->string('url');
            $table->string('publisher');
            $table->string('year');
            $table->timestamp('added_at')->useCurrent();
            $table->timestamp('update_at')->useCurrent();
            $table->integer('data_base')->index('data_base');
            $table->integer('id');
            $table->integer('status_selection')->default(3)->index('status_selection');
            $table->boolean('check_status_selection')->default(false);
            $table->integer('status_qa')->index('status_qa');
            $table->integer('id_gen_score')->index('id_gen_score');
            $table->boolean('check_qa');
            $table->float('score', 10, 0);
            $table->integer('status_extraction')->default(2)->index('status_extraction');
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
        Schema::dropIfExists('papers');
    }
};
