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

    /**
     * Cria a tabela 'users' no banco de dados.
     *
     * Esta migration define a estrutura da tabela de usuários, incluindo campos para:
     * - username: Nome de usuário único.
     * - firstname e lastname: Nome e sobrenome do usuário (opcionais).
     * - email: Endereço de e-mail único, com verificação de e-mail opcional.
     * - password: Senha do usuário.
     * - institution, lattes_link, address, city, country, postal, about, occupation: 
     *   Informações adicionais e opcionais sobre o usuário.
     * - rememberToken: Token para autenticação "lembrar-me".
     * - timestamps: Campos de criação e atualização automática.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('institution')->nullable();
            $table->string('lattes_link')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('postal')->nullable();
            $table->text('about')->nullable();
            $table->string('occupation')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
