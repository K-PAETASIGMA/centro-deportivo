<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cancha;
use App\Models\Reserva;

new class extends Component
{
    use WithPagination;

    public $nombre, $tipo, $precio_por_hora, $cancha_id;
    public $isModalOpen = false;

    // --- PROPIEDADES COMPUTADAS ---
    // Reemplazan a los métodos with()
    
    // Accede en Blade como $this->canchas
    public function getCanchasProperty() {
        return Cancha::latest()->paginate(10);
    }

    // Accede en Blade como $this->todasLasReservas
    public function getTodasLasReservasProperty() {
        return Reserva::with(['user', 'cancha'])->latest()->get();
    }

    // --- MÉTODOS DEL MODAL ---
    public function abrirModal() {
        $this->reset(['nombre', 'tipo', 'precio_por_hora', 'cancha_id']);
        $this->isModalOpen = true;
    }

    public function cerrarModal() {
        $this->isModalOpen = false;
    }

    // --- ACCIONES ---
    public function guardar() {
        $this->validate([
            'nombre' => 'required|min:3',
            'tipo' => 'required',
            'precio_por_hora' => 'required|numeric',
        ]);

        Cancha::updateOrCreate(['id' => $this->cancha_id], [
            'nombre' => $this->nombre,
            'tipo' => $this->tipo,
            'precio_por_hora' => $this->precio_por_hora,
        ]);

        session()->flash('message', $this->cancha_id ? 'Cancha actualizada.' : 'Cancha creada.');
        $this->cerrarModal();
    }

    public function editar($id) {
        $cancha = Cancha::findOrFail($id);
        $this->cancha_id = $id;
        $this->nombre = $cancha->nombre;
        $this->tipo = $cancha->tipo;
        $this->precio_por_hora = $cancha->precio_por_hora;
        $this->isModalOpen = true;
    }

    public function borrar($id) {
        Cancha::find($id)->delete();
        session()->flash('message', 'Cancha eliminada.');
    }
};
?>

<div class="p-6 lg:p-10 space-y-12">
    <div>
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">Configuración de Canchas</h2>
                <p class="text-sm text-zinc-500">Crea, edita o elimina las canchas disponibles en el centro.</p>
            </div>
            <button wire:click="abrirModal()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow-md">
                + Nueva Cancha
            </button>
        </div>

        <div class="bg-white dark:bg-zinc-900 shadow-sm border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="p-4 text-left text-xs font-semibold uppercase text-zinc-500">Nombre</th>
                        <th class="p-4 text-left text-xs font-semibold uppercase text-zinc-500">Tipo</th>
                        <th class="p-4 text-left text-xs font-semibold uppercase text-zinc-500">Precio/Hora</th>
                        <th class="p-4 text-right text-xs font-semibold uppercase text-zinc-500">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach($this->canchas as $cancha)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition">
                            <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-200">{{ $cancha->nombre }}</td>
                            <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                <span class="capitalize">{{ $cancha->tipo }}</span>
                            </td>
                            <td class="px-6 py-4 text-zinc-600 dark:text-zinc-400">
                                ${{ number_format($cancha->precio_por_hora, 2) }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-3">
                                <button wire:click="editar({{ $cancha->id }})" class="text-blue-600 hover:text-blue-800 font-medium">Editar</button>
                                <button wire:click="borrar({{ $cancha->id }})" 
                                        wire:confirm="¿Estás seguro de eliminar esta cancha?"
                                        class="text-red-600 hover:text-red-800 font-medium">Borrar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $this->canchas->links() }}
            </div>
        </div>
    </div>

    <hr class="border-zinc-200 dark:border-zinc-800">

    <div>
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">Reservas del Sistema</h2>
            <p class="text-sm text-zinc-500">Visualiza quién ha reservado y el estado de sus pagos.</p>
        </div>

        <div class="bg-white dark:bg-zinc-900 shadow-sm border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800">
                    <tr>
                        <th class="p-4 text-left text-xs font-semibold uppercase text-zinc-500">Cancha</th>
                        <th class="p-4 text-left text-xs font-semibold uppercase text-zinc-500">Cliente</th>
                        <th class="p-4 text-left text-xs font-semibold uppercase text-zinc-500">Fecha y Hora</th>
                        <th class="p-4 text-center text-xs font-semibold uppercase text-zinc-500">Estado Pago</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach($this->todasLasReservas as $reserva)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition">
                            <td class="px-6 py-4 text-zinc-900 dark:text-zinc-200">{{ $reserva->cancha->nombre }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium dark:text-white">{{ $reserva->user->name ?? 'N/A' }}</div>
                                <div class="text-xs text-zinc-500">{{ $reserva->user->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-zinc-600 dark:text-zinc-400">
                                {{ \Carbon\Carbon::parse($reserva->fecha_inicio)->format('d M, Y - H:i') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $reserva->estado_pago === 'completado' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ strtoupper($reserva->estado_pago) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL --}}
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div class="bg-white dark:bg-zinc-900 p-8 rounded-2xl shadow-2xl w-full max-w-md border border-zinc-200 dark:border-zinc-700">
                <h3 class="text-xl font-bold mb-6 dark:text-white">{{ $cancha_id ? 'Editar Cancha' : 'Nueva Cancha' }}</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1 dark:text-zinc-300">Nombre</label>
                        <input type="text" wire:model="nombre" class="w-full p-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1 dark:text-zinc-300">Tipo de Deporte</label>
                        <select wire:model="tipo" class="w-full p-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                            <option value="">Seleccione</option>
                            <option value="fútbol">Fútbol</option>
                            <option value="tenis">Tenis</option>
                            <option value="básquet">Básquet</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1 dark:text-zinc-300">Precio por Hora</label>
                        <input type="number" wire:model="precio_por_hora" class="w-full p-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                    </div>
                </div>
                <div class="flex justify-end mt-8 space-x-3">
                    <button wire:click="cerrarModal()" class="px-4 py-2 text-zinc-500 hover:text-zinc-700">Cancelar</button>
                    <button wire:click="guardar()" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold">Guardar</button>
                </div>
            </div>
        </div>
    @endif
</div>