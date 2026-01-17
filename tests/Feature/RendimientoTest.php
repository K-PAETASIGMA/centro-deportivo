<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

// Forzamos el uso de RefreshDatabase solo en este archivo para asegurar que cree las tablas
uses(RefreshDatabase::class);

test('el dashboard carga en tiempo optimo para garantizar escalabilidad', function () {
    // Creamos el usuario para la prueba
    $user = User::factory()->create();

    // Medimos el tiempo
    $inicio = microtime(true);
    
    $response = $this->actingAs($user)->get('/dashboard');
    
    $fin = microtime(true);
    $tiempoTotal = $fin - $inicio;

    // Verificaciones
    $response->assertStatus(200);
    
    // El dashboard debe cargar en menos de 500ms (0.5 segundos)
    expect($tiempoTotal)->toBeLessThan(0.5);
});