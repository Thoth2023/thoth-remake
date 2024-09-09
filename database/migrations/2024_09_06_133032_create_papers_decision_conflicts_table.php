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
        Schema::create('paper_decision_conflicts', function (Blueprint $table) {
            $table->id();
            $table->integer('id_paper')->index('id_paper');
            $table->string('phase');
            $table->integer('id_member')->index('id_member');
            $table->string('old_status_paper')->nullable();
            $table->string('new_status_paper')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('id_paper')->references('id_paper')->on('papers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_member')->references('id_members')->on('members')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paper_phase_changes');
    }
};
