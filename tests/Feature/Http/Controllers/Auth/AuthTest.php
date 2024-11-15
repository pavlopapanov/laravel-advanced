<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Enums\RolesEnum;
use App\Models\User;
use Tests\Feature\Traits\SetupTrait;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use SetupTrait;

    public function test_if_user_can_register_with_valid_data()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'admin@admin.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', ['email' => 'admin@admin.com']);
    }

    public function test_user_cannot_register_with_invalid_data()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => '123',
            'password_confirmation' => 'wrong-confirmation',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
        $this->assertDatabaseMissing('users', ['email' => 'invalid-email']);
    }

    public function test_if_user_can_login_with_valid_data()
    {
        $user = User::factory()->create([
            'email' => 'john.doe@example.com',
            'password' => 'password',
        ]);

        $response = $this->post('/login', [
            'email' => 'john.doe@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_if_user_can_login_with_invalid_data()
    {
        $response = $this->post('/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }
}
