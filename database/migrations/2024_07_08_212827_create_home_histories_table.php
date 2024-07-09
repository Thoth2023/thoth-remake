<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('home_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_manager_id')->constrained('home_managers')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->string('icon')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('home_histories');
    }
};
