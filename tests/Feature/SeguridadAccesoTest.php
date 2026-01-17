<?php

namespace Tests\Feature;

use App\Models\User;

test('un usuario comun no tiene acceso a la configuracion de canchas', function () {
    // Eliminamos 'is_admin' para que no choque con tu base de datos actual
    $user = User::factory()->create();

    // Intentamos entrar a una ruta que debería ser solo para admins
    $response = $this->actingAs($user)->get('/admin/canchas');

    // Si tu middleware funciona, debería dar 403 o redirigir
    // Si aún no has creado el middleware, puedes usar 302 o 404 según tu código
    $response->assertStatus(403); 
});