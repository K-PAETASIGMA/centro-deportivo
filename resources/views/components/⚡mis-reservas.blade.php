<?php

use Livewire\Component;
use App\Models\Reserva;

new class extends Component
{
    public function with()
    {
        return [
            // Traemos las reservas del usuario logueado con su relación de cancha
            'reservas' => Reserva::where('user_id', Auth::id())
                ->with('cancha')
                ->latest()
                ->get()
        ];
    }
};
?>

<div>
    <div class="p-6 lg:p-10">
        <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Mis Reservas</h1>
                    <p class="text-zinc-500 dark:text-zinc-400">Historial de pagos e instalaciones</p>
                </div>
                
                <flux:button href="{{ route('reservas.crear') }}" variant="primary" wire:navigate>
                    Nueva Reserva
                </flux:button>
            </div>

            @if($reservas->isEmpty())
                <div class="flex flex-col items-center justify-center p-12 bg-zinc-50 dark:bg-zinc-900 border border-dashed border-zinc-200 dark:border-zinc-700 rounded-xl">
                    <div class="text-zinc-400 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-medium text-zinc-900 dark:text-white">No tienes reservas aún</h2>
                    <p class="text-zinc-500">Tus próximas citas aparecerán aquí.</p>
                </div>
            @else
                <div class="overflow-hidden border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm">
                    <table class="w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                        <thead class="bg-zinc-50 dark:bg-zinc-800">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Cancha</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Fecha y Hora</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($reservas as $reserva)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-white">
                                        {{ $reserva->cancha->nombre }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ \Carbon\Carbon::parse($reserva->fecha_inicio)->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-zinc-900 dark:text-white">
                                        ${{ number_format($reserva->total, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($reserva->estado_pago === 'pagado')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                PAGADO
                                            </span>
                                        @else
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    PENDIENTE
                                                </span>
                                                <a href="{{ route('checkout', $reserva->id) }}" class="text-blue-600 hover:text-blue-900 text-xs font-bold underline" wire:navigate>
                                                    Pagar
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
    </div>
</div>