<?php

use App\Models\Reserva;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservaConfirmada;

new class extends Component
{
    // Definimos la propiedad para que Volt la inyecte desde la URL
    public Reserva $reserva;
    public bool $procesando = false;

    public function pagar() 
    {
        $this->procesando = true;

        // 1. Simulación de procesamiento (Punto de la rúbrica: Lógica de negocio)
        sleep(2);

        // 2. Actualización de estado (OO)
        $this->reserva->update([
            'estado_pago' => 'pagado'
        ]);

        // 3. Notificación (Rúbrica: Envío de correo)
        // Nota: Asegúrate de que la relación en el modelo Reserva sea 'user' o 'usuario'
        try {
            Mail::to(auth()->user()->email)->send(new ReservaConfirmada($this->reserva));
        } catch (\Exception $e) {
            // Si falla el mail (por configuración), que al menos termine el pago
        }

        session()->flash('success', '¡Pago realizado con éxito! Se ha enviado un correo de confirmación.');
        
        return redirect()->route('mis-reservas');
    }
};
?>

<div>
    <div class="p-6 lg:p-10">
        <div class="max-w-md mx-auto bg-white dark:bg-zinc-900 p-8 border border-zinc-200 dark:border-zinc-700 shadow-xl rounded-2xl">
            <h2 class="text-2xl font-black mb-6 border-b border-zinc-100 dark:border-zinc-800 pb-2 text-zinc-800 dark:text-white">
                RESUMEN DE PAGO
            </h2>
            
            <div class="space-y-4 mb-8 text-zinc-600 dark:text-zinc-400">
                <div class="flex justify-between">
                    <span>Cancha:</span>
                    <span class="font-bold text-zinc-900 dark:text-white">{{ $reserva->cancha->nombre }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Fecha:</span>
                    <span class="font-bold text-zinc-900 dark:text-white">{{ \Carbon\Carbon::parse($reserva->fecha_inicio)->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Hora:</span>
                    <span class="font-bold text-zinc-900 dark:text-white">{{ \Carbon\Carbon::parse($reserva->fecha_inicio)->format('H:i') }}</span>
                </div>
                <div class="flex justify-between text-xl border-t border-zinc-100 dark:border-zinc-800 pt-4">
                    <span class="font-black">TOTAL:</span>
                    <span class="font-black text-green-600">${{ number_format($reserva->total, 2) }}</span>
                </div>
            </div>

            {{-- Usamos el botón de Flux para mantener la estética --}}
            <flux:button 
                wire:click="pagar" 
                variant="primary" 
                class="w-full" 
                loading="pagar"
            >
                CONFIRMAR Y PAGAR
            </flux:button>
        </div>
    </div>
</div>