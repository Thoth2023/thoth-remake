<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('project_notifications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->integer('project_id')->index('project_id');
            $table->string('type');
            $table->text('message');
            $table->boolean('read')->default(false);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('project_id')->references('id_project')->on('project')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_notifications');
    }
};
