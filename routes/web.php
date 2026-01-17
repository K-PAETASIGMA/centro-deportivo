<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas protegidas para Clientes y Admins
Route::middleware(['auth'])->group(function () {
    
    // Si tus archivos están en resources/views/components/
    // Prueba llamarlos directamente por su nombre de archivo
    Volt::route('/reservar', 'reservar-cancha')->name('reservas.crear');
    Volt::route('/mis-reservas', 'mis-reservas')->name('mis-reservas');
    Volt::route('/checkout/{reserva}', 'checkout-reserva')->name('checkout');

    Route::middleware(['role:admin'])->group(function () {
        Volt::route('/admin/canchas', 'admin.gestion-canchas')->name('admin.canchas');
    });
});
require __DIR__.'/settings.php';
