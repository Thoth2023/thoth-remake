<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('papers', function (Blueprint $table) {
            $table->string('doi')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('papers', function (Blueprint $table) {
            $table->string('doi')->nullable(false)->change();
        });
    }
};
