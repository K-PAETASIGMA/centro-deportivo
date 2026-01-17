<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class cancha extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'tipo', 'precio_por_hora', 'esta_disponible'];

    // Relación: Una cancha puede tener muchas reservas
    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class);
    }
}
