<?php
use Spatie\Permission\Models\Role;

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertOk();
});

it('new users can register', function () {

    Role::create([
        'name' => 'cliente',
        'guard_name' => 'web',
    ]);

    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasNoErrors()
             ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});
