<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

//usar essas variaveis para testar a criação e remoção
define('idAtualDomain',10);
define('idAtualKeyword',3);

class PlanningOverallTest extends TestCase
{
    use DatabaseTransactions;

    public function test_planning_page(){
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->get('/planning/1');

        $response->assertStatus(200);
    }

    //Test of creating a domain
    public function test_domain(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->post('/planning/domain',['id_project'=>'1','description'=>'h_(.%5263+-*¨%&¨$@vsd']);

        $response->assertRedirect('/planning/1','Error creating domain');
    }

    //Test of editing a domain
    public function test_domain_edit(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->put('/planning/domain/'.idAtualDomain,['id_project'=>'1','description'=>'project141ffdfg45+-*&¨$%$#*&']);

        $response->assertRedirect('/planning/1','Error editing domain');
    }


    //Test domain removal
    public function test_domain_remove(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->delete('/planning/domain/'.idAtualDomain);

        $response->assertRedirect('/planning/1','Error removing this domain');
    }

    //Test to bind to a language
    public function test_add_language(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->post('/planning/language',['id_project'=>'1','id_language'=>'1']);

        $response->assertRedirect('/planning/1','Error adding language');
    }

    //Test to unbind a language
    public function test_remove_language(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->delete('/planning/language/1');

        $response->assertRedirect('/planning/1','Error removing language');
    }

    //Test to link to a study type
    public function test_add_study_type(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->post('/planning/study_type',['id_project'=>'1','id_study_type'=>'1']);

        $response->assertRedirect('/planning/1','Error adding study type');
    }

    //Test to unlink a study type
    public function test_remove_study_type(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->delete('/planning/study_type/1');

        $response->assertRedirect('/planning/1','Error removing study type');
    }

    //Test of creating a keyword
    public function test_keyword(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->post('/planning/keyword',['id_project'=>'1','description'=>'jagagagdasgdas']);

        $response->assertRedirect('/planning/1','Error creating keyword');
    }

    //Test of editing a keyword
    public function test_keyword_edit(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->put('/planning/keyword/'.idAtualKeyword,['id_project'=>'1','description'=>'project']);

        $response->assertRedirect('/planning/1','Error editing keyword');
    }

    //Test removing a keyword
    public function test_keyword_remove(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->delete('/planning/keyword/'.idAtualKeyword);

        $response->assertRedirect('/planning/1','Error deleting keyword');
    }



}
