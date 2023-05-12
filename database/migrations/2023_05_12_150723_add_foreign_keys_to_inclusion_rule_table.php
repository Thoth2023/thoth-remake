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
        Schema::table('inclusion_rule', function (Blueprint $table) {
            $table->foreign(['id_rule'], 'inclusion_rule_ibfk_2')->references(['id_rule'])->on('rule')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id_project'], 'inclusion_rule_ibfk_1')->references(['id_project'])->on('project')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inclusion_rule', function (Blueprint $table) {
            $table->dropForeign('inclusion_rule_ibfk_2');
            $table->dropForeign('inclusion_rule_ibfk_1');
        });
    }
};
