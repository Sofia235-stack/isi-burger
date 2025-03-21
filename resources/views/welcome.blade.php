<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ISI Burger</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
<div
    class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
    @if (Route::has('login'))
        <livewire:welcome.navigation/>
    @endif

    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <div class="flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">
                <!-- Fond cercle -->
                <circle cx="100" cy="100" r="95" fill="#FFD700" stroke="#FF4500" stroke-width="5"/>
                <!-- Partie supérieure du burger -->
                <rect x="50" y="80" width="100" height="20" rx="10" fill="#D2691E"/>
                <!-- Salade -->
                <rect x="55" y="100" width="90" height="10" rx="5" fill="#32CD32"/>
                <!-- Partie inférieure du burger -->
                <rect x="50" y="110" width="100" height="20" rx="10" fill="#D2691E"/>
                <!-- Texte ISI Burger -->
                <text x="100" y="170" font-family="Arial, Helvetica, sans-serif" font-size="20" fill="#FF4500"
                      text-anchor="middle" font-weight="bold">
                    ISI Burger
                </text>
            </svg>

        </div>

        <div class="text-center mt-10">
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Bienvenue chez ISI Burger!</h1>
            <p class="mt-4 text-lg text-gray-500 dark:text-gray-400">Découvrez nos délicieux burgers et passez commande
                facilement.</p>
            <a href="{{ route('catalogue') }}"
               class="mt-6 px-8 py-3 text-white bg-red-500 rounded-full hover:bg-red-600 transition-all">Voir le
                menu</a>
        </div>
    </div>
</div>
</body>
</html>

