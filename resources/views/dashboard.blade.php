<x-layouts::app :title="__('Dashboard')">
<div class="p-6 lg:p-10">
        <flux:heading size="xl" level="1">Bienvenido, {{ auth()->user()->name }}</flux:heading>
        <flux:subheading>Aquí tienes un resumen de la actividad de hoy.</flux:subheading>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            @role('admin')
                {{-- Estadísticas para el Admin --}}
                <div class="bg-blue-50 dark:bg-blue-900/20 p-6 rounded-2xl border border-blue-100 dark:border-blue-800">
                    <p class="text-blue-600 dark:text-blue-400 text-sm font-bold uppercase">Total Ganado</p>
                    <h2 class="text-3xl font-black text-blue-900 dark:text-white mt-2">
                        ${{ number_format(\App\Models\Reserva::where('estado_pago', 'pagado')->sum('total'), 2) }}
                    </h2>
                </div>

                <div class="bg-zinc-50 dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
                    <p class="text-zinc-500 text-sm font-bold uppercase">Canchas Activas</p>
                    <h2 class="text-3xl font-black mt-2 text-zinc-900 dark:text-white">
                        {{ \App\Models\Cancha::where('esta_disponible', true)->count() }}
                    </h2>
                </div>
            @else
                {{-- Estadísticas para el Cliente --}}
                <div class="bg-green-50 dark:bg-green-900/20 p-6 rounded-2xl border border-green-100 dark:border-green-800">
                    <p class="text-green-600 dark:text-green-400 text-sm font-bold uppercase">Tus Reservas</p>
                    <h2 class="text-3xl font-black text-green-900 dark:text-white mt-2">
                        {{ \App\Models\Reserva::where('user_id', auth()->id())->count() }}
                    </h2>
                </div>

                <div class="bg-zinc-50 dark:bg-zinc-900 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-700">
                    <p class="text-zinc-500 text-sm font-bold uppercase">Próximo Partido</p>
                    <h2 class="text-lg font-bold mt-2 text-zinc-900 dark:text-white">
                        @php
                            $proxima = \App\Models\Reserva::where('user_id', auth()->id())
                                ->where('fecha_inicio', '>=', now())
                                ->first();
                        @endphp
                        {{ $proxima ? \Carbon\Carbon::parse($proxima->fecha_inicio)->diffForHumans() : 'No hay pendientes' }}
                    </h2>
                </div>
            @endrole
        </div>

        {{-- Sección inferior: Acceso rápido --}}
        <div class="mt-10">
            <flux:heading size="lg">Acciones rápidas</flux:heading>
            <div class="flex gap-4 mt-4">
                @role('admin')
                    <flux:button href="{{ route('admin.canchas') }}" icon="cog-6-tooth" wire:navigate>Gestionar Instalaciones</flux:button>
                @else
                    <flux:button href="{{ route('reservas.crear') }}" variant="primary" icon="calendar-days" wire:navigate>Nueva Reserva</flux:button>
                    <flux:button href="{{ route('mis-reservas') }}" variant="ghost" wire:navigate>Ver mis pagos</flux:button>
                @endrole
            </div>
        </div>
    </div>
</x-layouts::app>
