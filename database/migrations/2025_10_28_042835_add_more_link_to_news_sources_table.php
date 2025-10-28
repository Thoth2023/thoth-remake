<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('news_sources', function (Blueprint $table) {
            $table->string('more_link')->nullable()->after('url');
        });
    }

    public function down()
    {
        Schema::table('news_sources', function (Blueprint $table) {
            $table->dropColumn('more_link');
        });
    }
};
