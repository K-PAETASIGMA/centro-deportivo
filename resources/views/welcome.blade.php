<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SportCenter | Gestión de Reservas Inteligentes</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] antialiased">

    <nav class="flex items-center justify-between px-6 py-4 max-w-7xl mx-auto border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
        <div class="flex items-center gap-2">
            <div class="size-8 bg-[#f53003] rounded-lg"></div>
            <span class="font-bold text-xl tracking-tight">SportCenter</span>
        </div>
        <div class="flex items-center gap-6">
            @if (Route::has('login'))
                <div class="flex gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium hover:text-[#f53003] transition">Mi Panel</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium hover:text-[#f53003] transition">Acceder</a>
                        <a href="{{ route('register') }}" class="bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1b1b18] px-4 py-2 rounded-full text-sm font-medium hover:opacity-90 transition">Comenzar Gratis</a>
                    @endauth
                </div>
            @endif
            <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" icon="moon" variant="subtle" aria-label="Toggle dark mode" />
        </div>
    </nav>

    <header class="relative px-6 py-20 lg:py-32 overflow-hidden border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-5xl lg:text-7xl font-bold leading-[1.1] mb-6 tracking-tight">
                    La cancha perfecta, <br>
                    <span class="text-[#f53003]">a un click de distancia.</span>
                </h1>
                <p class="text-lg text-[#706f6c] dark:text-[#A1A09A] mb-8 max-w-lg leading-relaxed">
                    SportCenter es la plataforma definitiva para centros deportivos. Reserva, paga y gestiona tus partidos en tiempo real sin complicaciones.
                </p>
                <div class="flex flex-wrap gap-4">
                    <button class="bg-[#f53003] text-white px-8 py-4 rounded-xl font-bold shadow-lg hover:brightness-110 transition" ><a href="{{ route('login') }}" class="text-white">Iniciar ahora</a></button>
                </div>
            </div>
            <div class="relative">
                <div class="bg-gradient-to-tr from-[#f53003]/20 to-transparent absolute inset-0 blur-3xl rounded-full"></div>
                <div class="relative bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-2xl p-4 shadow-2xl transform rotate-2">
                    <div class="aspect-video bg-zinc-100 dark:bg-zinc-900 rounded-lg flex items-center justify-center italic text-zinc-400">
                        <img src="{{ asset('storage/img/centro-deportivo.jpg') }}" alt="Centro Deportivo">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="px-6 py-24 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <span class="text-[#f53003] font-bold tracking-widest text-xs uppercase">Nuestros Servicios</span>
            <h2 class="text-3xl lg:text-4xl font-bold mt-4">Todo lo que necesitas para tu club</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="group p-8 rounded-2xl border border-transparent hover:border-[#e3e3e0] dark:hover:border-[#3E3E3A] hover:bg-white dark:hover:bg-[#161615] transition-all duration-300">
                <div class="size-12 bg-zinc-100 dark:bg-zinc-800 rounded-xl flex items-center justify-center mb-6 group-hover:bg-[#f53003] group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Reservas 24/7</h3>
                <p class="text-[#706f6c] dark:text-[#A1A09A] leading-relaxed">
                    Nuestro sistema automatizado permite reservar canchas de fútbol, tenis o básquet en cualquier momento, eliminando llamadas y esperas.
                </p>
            </div>

            <div class="group p-8 rounded-2xl border border-transparent hover:border-[#e3e3e0] dark:hover:border-[#3E3E3A] hover:bg-white dark:hover:bg-[#161615] transition-all duration-300">
                <div class="size-12 bg-zinc-100 dark:bg-zinc-800 rounded-xl flex items-center justify-center mb-6 group-hover:bg-[#f53003] group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.1c.827.215 1.628-.406 1.628-1.265V11.024m-18 2.75 6-6.75 4.5 4.5 1.25-1.25M18 10.25l6-6.75m0 0H20.25m3.75 0V8.25" /></svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Pagos Seguros</h3>
                <p class="text-[#706f6c] dark:text-[#A1A09A] leading-relaxed">
                    Integración directa con pasarelas de pago. Paga tu cuota al instante y asegura tu espacio sin necesidad de efectivo.
                </p>
            </div>
        </div>
    </section>

    <footer class="bg-zinc-50 dark:bg-[#0d0d0c] border-t border-[#e3e3e0] dark:border-[#3E3E3A] py-12 px-6 text-center">
        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
            &copy; {{ date('Y') }} SportCenter S.A. Elevando el nivel del deporte local.
        </p>
    </footer>

</body>
</html>