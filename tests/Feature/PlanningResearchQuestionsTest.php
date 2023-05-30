<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlanningResearchQuestionsTest extends TestCase
{
    //Teste para testar a funcionalidade de adicionar questão
    public function test_add_research_questions(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->post('/planning/research_questions/add',['id_project'=>'1','description'=>'abc','id'=>'RQ2']);

        $response->assertRedirect('/planning/research_questions');
    }

    //Teste para testar a funcionalidade de adicionar questão com o campo id ja existente
    public function test_add_research_questions_id_exists(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->post('/planning/research_questions/add',['id_project'=>'1','description'=>'abcdefg','id'=>'RQ2']);

        $response->assertRedirect('/planning/research_questions');
    }

    //Teste para testar a funcionalidade de adicionar questão com o id da questions vazio
    public function test_add_research_questions_void_id(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->post('/planning/research_questions/add',['id_project'=>'1','description'=>'adbcd']);

        $response->assertRedirect('/planning/research_questions');
    }

    //Teste para testar a funcionalidade de adicionar questão com o id contendo caracteres especiais
    public function test_add_research_questions_id_special_characters(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->post('/planning/research_questions/add',['id_project'=>'1','description'=>'adbcde','id'=>'_$ç^`^RQ2']);

        $response->assertRedirect('/planning/research_questions');
    }

    //Teste para testar a funcionalidade de adicionar questão com o id contendo caracteres especiais
    public function test_edit_research_questions(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->post('/planning/research_questions/add',['id_project'=>'1','description'=>'adbcde','id'=>'_$ç^`^RQ2']);

        $response->assertRedirect('/planning/research_questions');
    }
}
