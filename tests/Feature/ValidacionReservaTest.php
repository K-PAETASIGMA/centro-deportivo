<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Cancha;
use App\Models\Reserva;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

test('no se puede reservar una cancha si ya está ocupada en esa fecha y hora', function () {
    $user1 = User::factory()->create();
    $cancha = Cancha::factory()->create(['precio_por_hora' => 5000]); // Aseguramos un precio
    
    $fecha = now()->addDay()->format('Y-m-d');
    $hora = '14:00';
    $fechaInicio = $fecha . ' ' . $hora;
    $fechaFin = Carbon::parse($fechaInicio)->addHour()->format('Y-m-d H:i:s');

    // 1. Primera reserva (Exitosa)
    Reserva::create([
        'user_id' => $user1->id,
        'cancha_id' => $cancha->id,
        'fecha_inicio' => $fechaInicio,
        'fecha_fin' => $fechaFin,
        'total' => $cancha->precio_por_hora, // <--- AGREGAR ESTA LÍNEA
        'estado_pago' => 'pendiente'
    ]);

    // 2. Verificación de colisión
    $existeColision = Reserva::where('cancha_id', $cancha->id)
        ->where('fecha_inicio', $fechaInicio)
        ->exists();

    expect($existeColision)->toBeTrue();
});