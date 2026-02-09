<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_be_listed()
    {
        $response = $this->get('/usuarios');

        $response->assertStatus(200);
    }

    public function test_user_can_be_created()
    {
        $response = $this->post('/usuarios', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'fecha_nacimiento' => '1990-01-01',
            'genero' => 'hombre',
            'numero_telefono' => '123456789',
        ]);

        $response->assertRedirect('/usuarios');
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'genero' => 'hombre',
        ]);
    }

    public function test_user_can_be_updated()
    {
        $user = User::factory()->create();

        $response = $this->put("/usuarios/{$user->id}", [
            'name' => 'Updated User',
            'email' => 'updated@example.com',
            'fecha_nacimiento' => '1992-02-02',
            'genero' => 'mujer',
            'numero_telefono' => '987654321',
        ]);

        $response->assertRedirect('/usuarios');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'updated@example.com',
            'genero' => 'mujer',
        ]);
    }

    public function test_user_can_be_deleted()
    {
        $user = User::factory()->create();

        $response = $this->delete("/usuarios/{$user->id}");

        $response->assertRedirect('/usuarios');
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }
}