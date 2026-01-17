<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSecurityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_comun_no_puede_acceder_a_gestion_de_canchas()
    {
        $user = User::factory()->create(); // Usuario sin rol admin

        $response = $this->actingAs($user)->get('/admin/canchas');

        // Debería dar 403 (Prohibido) o redirigir si usas middleware
        $response->assertStatus(403);
    }
}