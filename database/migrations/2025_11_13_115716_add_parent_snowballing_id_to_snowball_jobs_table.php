<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('snowball_jobs', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_snowballing_id')->nullable()->after('paper_id');
        });
    }

    public function down()
    {
        Schema::table('snowball_jobs', function (Blueprint $table) {
            $table->dropColumn('parent_snowballing_id');
        });
    }
};
