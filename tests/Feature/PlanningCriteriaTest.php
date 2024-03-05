<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlanningCriteriaTest extends TestCase
{

    use DatabaseTransactions;

    //Teste de comunicação com a rota
    public function test_status_criteria(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->get('/planning/1/criteria');

        $response->assertStatus(200);
    }

    //teste de criação de criteria
    public function test_add_criteria(): void
    {

        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->post('/planning/criteria/add',['id_project'=>'1','id'=>'C3','description'=>'aaa','type'=>'Inclusion','pre_selected'=>'1']);

        $response->assertRedirect('/planning/1/criteria');
    }

    //teste de criação de criteria com ID ja exitente
    public function test_add_criteria_id_ex(): void
    {

        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->post('/planning/criteria/add',['id_project'=>'1','id'=>'C3','description'=>'aaa','type'=>'Inclusion','pre_selected'=>'1']);

        $response->assertRedirect('/planning/1/criteria');
    }

    //teste de criação de criteria com ID vazio
    public function test_add_criteria_void_id(): void
    {

        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->post('/planning/criteria/add',['id_project'=>'1','id'=>'','description'=>'aaa','type'=>'Inclusion','pre_selected'=>'1']);

        $response->assertRedirect('/planning/1/criteria');
    }

    //teste para editar a criteria
    public function test_edit_criteria(): void
    {

        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->put('/planning/criteria/4',['id_project'=>'1','id'=>'C4','description'=>'aaaaaa','type'=>'Exclusion','pre_selected'=>'1']);

        $response->assertRedirect('/planning/1/criteria');
    }

    //teste para editar a criteria com id existente
    public function test_edit_criteria_id_ex(): void
    {

        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->put('/planning/criteria/4',['id_project'=>'1','id'=>'C3','description'=>'aaaaaa','type'=>'Exclusion','pre_selected'=>'1']);

        $response->assertRedirect('/planning/1/criteria');
    }

    //teste para editar a criteria com id vazio
    public function test_edit_criteria_void_id(): void
    {

        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->put('/planning/criteria/4',['id_project'=>'1','id'=>'','description'=>'aaaaaa','type'=>'Exclusion','pre_selected'=>'1']);

        $response->assertRedirect('/planning/1/criteria');
    }

    //teste para editar o pre selected criteria
    public function test_edit_pre_selected_criteria(): void
    {

        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->put('/planning/criteria/4',['id'=>'C4','description'=>'aaaaaa','type'=>'Exclusion','pre_selected'=>'0']);

        $response->assertRedirect('/planning/1/criteria');
    }

    //Teste de editar o selected criteria com o campo vazio
    public function test_edit_pre_selected_criteria_void(): void
    {

        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->put('/planning/criteria/4',['id'=>'C2','description'=>'aaaaaa','type'=>'Exclusion','pre_selected'=>'']);

        $response->assertRedirect('/planning/1/criteria');
    }

    public function test_delete_criteria(): void
    {

        $response = $this->post('/login', [
            'email' => 'admin@argon.com',
            'password' => 'secret',
        ]);

        $response = $this->delete('/criteria/4');

        $response->assertRedirect('/planning/1/criteria');
    }


}
