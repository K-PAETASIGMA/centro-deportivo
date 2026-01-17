<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Esta línea requiere que la tabla 'canchas' ya exista:
            $table->foreignId('cancha_id')->constrained('canchas')->onDelete('cascade'); 
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->string('estado_pago')->default('pendiente');
            $table->decimal('total', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
