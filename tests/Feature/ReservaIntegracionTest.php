<?php

use App\Models\User;
use App\Models\Cancha;
use App\Models\Reserva;
use Livewire\Volt\Volt;

test('un usuario puede seleccionar una cancha y agendar una reserva', function () {
    $user = User::factory()->create();
    $cancha = Cancha::create([
        'nombre' => 'Cancha de Fútbol 5',
        'tipo' => 'fútbol',
        'precio_por_hora' => 20,
        'esta_disponible' => true
    ]);

    // Prueba de Integración: ¿El componente Livewire guarda en la BD?
    Volt::actingAs($user)
        ->test('reservar-cancha')
        ->set('cancha_id', $cancha->id)
        ->set('fecha', now()->addDay()->format('Y-m-d'))
        ->set('hora', '18:00')
        ->call('agendar')
        ->assertHasNoErrors();

    // Prueba de Sistema: Verificamos la persistencia real
    expect(Reserva::where('user_id', $user->id)->exists())->toBeTrue();
});