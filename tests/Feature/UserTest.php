<?php

namespace Tests\Feature;

use http\Client\Curl\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_database(){
        $this->assertDatabaseHas('users',[
            'email'=>'skander@mail.com'
        ]);
    }

    public function test_login(){
        $response = $this->post('/login',[
            'email'=>'skander@mail.com',
            'password'=>'Skander1'
        ]);
        $response->assertStatus(200);
    }

    public function test_create_permission(){
        $user = \App\Models\User::find(1);
        $response = $this->actingAs($user)
            ->get('/user');
        $response->assertStatus(200);
    }
}
