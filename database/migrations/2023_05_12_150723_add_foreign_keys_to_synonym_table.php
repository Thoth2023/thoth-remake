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
        Schema::table('synonym', function (Blueprint $table) {
            $table->foreign(['id_term'], 'synonym_ibfk_1')->references(['id_term'])->on('term')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('synonym', function (Blueprint $table) {
            $table->dropForeign('synonym_ibfk_1');
        });
    }
};
