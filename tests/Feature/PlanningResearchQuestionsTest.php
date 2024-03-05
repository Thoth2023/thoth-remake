<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlanningResearchQuestionsTest extends TestCase
{

    /* Os testes não estão gerando valores dinamicos, ou seja, se for feito mais
     * de 1 teste subsequente sem mudar os valores, vai ser gerado alguns erros
     * Alguns testes vao dar erros mas é um Falso positivo*/

    use DatabaseTransactions;

    //Teste de comunicação com a rota
    public function test_status_research_questions(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->get('/planning/1/research_questions');

        $response->assertStatus(200);
    }

    //Teste para testar a funcionalidade de adicionar questão
    public function test_add_research_questions(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->post('/planning/research_questions/add', ['id_project' => '1', 'description' => 'abc', 'id' => 'RQ6']);

        $response->assertRedirect('/planning/1/research_questions');
    }

    //Teste para testar a funcionalidade de adicionar questão com o campo id ja existente
    public function test_add_research_questions_id_exists(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->post('/planning/research_questions/add', ['id_project' => '1', 'description' => 'abcdefg', 'id' => 'RQ5']);

        $response->assert('/planning/1/research_questions');
    }

    //Teste para testar a funcionalidade de adicionar questão com o id da questions vazio
    public function test_add_research_questions_void_id(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->post('/planning/research_questions/add', ['id_project' => '1', 'description' => 'adbcd', 'id' => '']);

        $response->assertRedirect('/planning/1/research_questions');
    }

    //Teste para testar a funcionalidade de adicionar questão com o id contendo caracteres especiais
    public function test_add_research_questions_id_special_characters(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->post('/planning/research_questions/add', ['id_project' => '1', 'description' => 'adbcde', 'id' => '_$ç^`^RQ2']);

        $response->assertRedirect('/planning/1/research_questions');
    }

    //Teste para testar a funcionalidade de editar questão
    public function test_edit_research_questions(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->put('/planning/research_questions/4', ['id_project' => '1', 'description' => 'adbcdeeeee', 'id' => 'RQQ6']);

        $response->assertRedirect('/planning/1/research_questions');
    }

    //Teste para testar a funcionalidade de editar questão com um id ja existente
    public function test_edit_research_questions_id_f1(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->put('/planning/research_questions/3', ['id_project' => '1', 'description' => 'adbcdeeeee', 'id' => 'RQ3']);

        $response->assertRedirect('/planning/1/research_questions');
    }

    //Teste para testar a funcionalidade de editar questão com um id com caracteres especiais
    public function test_edit_research_questions_id_f2(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->put('/planning/research_questions/3', ['id_project' => '1', 'description' => 'adbcdeeeee', 'id' => '$%&¨*_~^RQ2']);

        $response->assertRedirect('/planning/1/research_questions');
    }

    //Teste para testar a funcionalidade de editar question com um id vazio
    public function test_edit_research_questions_id_f3(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->put('/planning/research_questions/3', ['id_project' => '1', 'description' => 'adbcdeeeee', 'id' => '']);

        $response->assertRedirect('/planning/1/research_questions');
    }

    //Teste para testar a funcionalidade de excluir question
    public function test_delete_research_questions(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->delete('/planning/research_questions/1', ['id_project' => '1', 'id' => 'RQ6']);

        $response->assertRedirect('/planning/1/research_questions');
    }
}
