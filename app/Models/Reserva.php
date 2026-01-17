<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reserva extends Model
{

    use HasFactory; // 2. Usar dentro de la clase
    protected $fillable = ['user_id', 'cancha_id', 'fecha_inicio', 'fecha_fin', 'estado_pago', 'total'];
    
    // ESTA ES LA RELACIÓN QUE FALTA
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Relación: La reserva pertenece a un usuario
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación: La reserva pertenece a una cancha
    public function cancha(): BelongsTo
    {
        return $this->belongsTo(Cancha::class);
    }
}
