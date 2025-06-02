<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Migration para criar a tabela 'paper_decision_conflicts'.
     *
     * Esta migration define a estrutura da tabela responsável por armazenar conflitos de decisão relacionados a trabalhos (papers)
     * em diferentes fases do processo, associando membros e registrando mudanças de status, além de notas explicativas.
     *
     * Métodos utilizados:
     * - up(): Cria a tabela 'paper_decision_conflicts' com os seguintes campos:
     *   - id: Chave primária auto-incrementada.
     *   - id_paper: Referência ao trabalho (paper), indexado e com chave estrangeira para a tabela 'papers'.
     *   - phase: Fase do processo em que ocorreu o conflito.
     *   - id_member: Referência ao membro envolvido, indexado e com chave estrangeira para a tabela 'members'.
     *   - old_status_paper: Status anterior do trabalho (opcional).
     *   - new_status_paper: Novo status do trabalho (opcional).
     *   - note: Observações ou justificativas do conflito (opcional).
     *   - timestamps: Campos 'created_at' e 'updated_at' para controle de criação e atualização dos registros.
     *   - foreign: Define as restrições de integridade referencial para 'id_paper' e 'id_member', com atualização e deleção em cascata.
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
