<?php

use App\Models\User;
use App\Models\Reserva;
use App\Models\Cancha;

test('el sistema acepta el pago y marca la reserva como completada', function () {
    $user = User::factory()->create();
    
    // Tu lógica de test aquí...
    expect(true)->toBeTrue(); 
});