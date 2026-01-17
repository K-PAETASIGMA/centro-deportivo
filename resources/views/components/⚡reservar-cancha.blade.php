<?php

use Livewire\Component;
use App\Models\Cancha;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException; // <--- IMPORTANTE: Añade esta línea

new class extends Component
{
    public $canchas;
    public $cancha_id;
    public $fecha;
    public $hora;
    public $mensaje;

    // Definimos los bloques de horas disponibles
    public function getHorasDisponiblesProperty()
    {
        return [
            '08:00', '09:00', '10:00', '11:00', '12:00', 
            '13:00', '14:00', '15:00', '16:00', '17:00', 
            '18:00', '19:00', '20:00', '21:00'
        ];
    }

    public function with() {
        return [
            'reservas' => Reserva::where('user_id', Auth::id())->latest()->get()
        ];
    }

    public function mount() {
        $this->canchas = Cancha::where('esta_disponible', true)->get();
    }

    public function agendar() {
        $this->validate([
            'cancha_id' => 'required',
            'fecha' => 'required|after_or_equal:today',
            'hora' => 'required',
        ]);

        $fechaInicioFull = $this->fecha . ' ' . $this->hora;

        // 1. VALIDACIÓN DE DISPONIBILIDAD
        $yaReservado = Reserva::where('cancha_id', $this->cancha_id)
            ->where('fecha_inicio', $fechaInicioFull)
            ->exists();

        if ($yaReservado) {
            // Esto enviará el error directamente al input de 'hora' en tu vista
            throw ValidationException::withMessages([
                'hora' => 'Esta cancha ya está reservada para este horario.',
            ]);
        }

        // 2. OBTENER DATOS DE LA CANCHA
        $cancha = Cancha::find($this->cancha_id);
        
        // 3. CREAR LA RESERVA
        Reserva::create([
            'user_id' => Auth::id(),
            'cancha_id' => $this->cancha_id,
            'fecha_inicio' => $fechaInicioFull,
            // Calculamos fecha_fin sumando 1 hora
            'fecha_fin' => date('Y-m-d H:i:s', strtotime($fechaInicioFull . ' +1 hour')),
            'total' => $cancha->precio_por_hora,
            'estado_pago' => 'pendiente',
        ]);

        $this->mensaje = "¡Reserva pendiente! Proceda al pago.";
        
        // Limpiar campos después de reservar (opcional)
        $this->reset(['cancha_id', 'fecha', 'hora']);
        
        $this->dispatch('reserva-creada'); 
    }
};
?>

<div>
    <div class="p-6 bg-gray-50 rounded-xl border border-gray-200">
        <h2 class="text-2xl font-bold mb-4">Reservar Cancha</h2>

        @if($mensaje)
            <div class="bg-blue-100 text-blue-700 p-3 rounded mb-4">{{ $mensaje }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-bold">Seleccione Cancha</label>
                <select wire:model="cancha_id" class="w-full border p-2 rounded">
                    <option value="">-- Canchas disponibles --</option>
                    @foreach($canchas as $cancha)
                        <option value="{{ $cancha->id }}">{{ $cancha->nombre }} (${{ $cancha->precio_por_hora }}/h)</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold">Fecha</label>
                <input type="date" wire:model="fecha" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block font-bold">Hora</label>
                <select wire:model="hora" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Seleccione una hora</option>
                    @foreach($this->horasDisponibles as $h)
                        <option value="{{ $h }}">{{ $h }} hs</option>
                    @endforeach
                </select>
                @error('hora') 
                    <div class="mt-2 p-2 bg-red-50 border-l-4 border-red-500">
                        <span class="text-red-700 text-sm font-medium">{{ $message }}</span>
                    </div>
                @enderror
                </div>
        </div>

        <button wire:click="agendar" class="mt-6 bg-green-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-green-700 transition">
            CONFIRMAR Y PAGAR
        </button>
    </div>
    @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <p class="font-bold">Hubo un problema:</p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</div>