<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    /**
     * Cria a tabela 'failed_jobs' para armazenar informações sobre jobs que falharam durante o processamento.
     *
     * Campos:
     * - id: Identificador único do registro.
     * - uuid: Identificador único universal do job.
     * - connection: Nome da conexão utilizada pelo job.
     * - queue: Nome da fila onde o job estava.
     * - payload: Dados completos do job serializados.
     * - exception: Detalhes da exceção que causou a falha.
     * - failed_at: Timestamp indicando quando o job falhou.
     */
    public function up(): void
    {
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failed_jobs');
    }
};
