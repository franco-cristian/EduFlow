<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EduFlow - @yield('title', 'Panel')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <header x-data="{ mobileMenuOpen: false }" class="bg-education-primary shadow-md">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo y Navegación Desktop -->
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex-shrink-0 flex items-center space-x-2 text-white">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span class="text-xl font-bold">EduFlow</span>
                        </a>
                        <nav class="hidden md:ml-10 md:flex md:items-baseline md:space-x-4">
                            <a href="{{ route('dashboard') }}" class="text-white hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">Inicio</a>
                            @auth
                            @if(in_array(auth()->user()->role, ['student', 'teacher']))
                            <a href="{{ route(auth()->user()->role . '.projects.index') }}" class="text-white hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">Proyectos</a>
                            @endif
                            <button @click="$dispatch('toggle-chatbot')" class="text-white hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">Asistente IA</button>
                            @endauth
                        </nav>
                    </div>

                    <!-- Menú de Usuario y Hamburguesa -->
                    <div class="flex items-center">
                        <div class="hidden md:block">
                            @auth
                            <div x-data="{ userMenuOpen: false }" class="relative ml-3">
                                <button @click="userMenuOpen = !userMenuOpen" type="button" class="max-w-xs bg-education-secondary rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-education-dark focus:ring-white">
                                    <span class="sr-only">Abrir menú de usuario</span>
                                    <div class="h-8 w-8 rounded-full flex items-center justify-center font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                                </button>
                                <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-transition x-cloak class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mi Perfil</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cerrar sesión</button>
                                    </form>
                                </div>
                            </div>
                            @endauth
                        </div>
                        <div class="-mr-2 flex md:hidden">
                            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-education-secondary focus:outline-none">
                                <span class="sr-only">Abrir menú</span>
                                <svg x-show="!mobileMenuOpen" class="h-6 w-6 block" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                                <svg x-show="mobileMenuOpen" class="h-6 w-6 hidden" stroke="currentColor" fill="none" viewBox="0 0 24 24" x-cloak>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menú Móvil Desplegable -->
            <div x-show="mobileMenuOpen" class="md:hidden" x-cloak>
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="{{ route('dashboard') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Inicio</a>
                    @if(in_array(auth()->user()->role, ['student', 'teacher']))
                    <a href="{{ route(auth()->user()->role . '.projects.index') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Proyectos</a>
                    @endif
                    <button @click="$dispatch('toggle-chatbot'); mobileMenuOpen = false" class="text-gray-300 hover:bg-gray-700 hover:text-white block w-full text-left px-3 py-2 rounded-md text-base font-medium">Asistente IA</button>
                </div>
                @auth
                <div class="pt-4 pb-3 border-t border-gray-700">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-education-secondary flex items-center justify-center font-bold text-white">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-white">{{ auth()->user()->name }}</div>
                            <div class="text-sm font-medium leading-none text-gray-400">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        <a href="{{ route('profile.show') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Mi Perfil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Cerrar sesión</button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </header>

        <main>
            <div class="container mx-auto py-6 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- ... justo después de la etiqueta de cierre </main> ... --}}
    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                <div>
                    <h3 class="text-lg font-semibold mb-4">EduFlow</h3>
                    <p class="text-gray-400">Plataforma de gestión de proyectos académicos para instituciones educativas.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Enlaces Rápidos</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Documentación</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Soporte</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Política de Privacidad</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Desarrollador</h3>
                    <ul class="space-y-2">
                        {{-- ENLACE AL PORTAFOLIO AQUÍ --}}
                        <li>
                            <a href="https://tu-url-de-portafolio.com" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition">
                                Ver Portafolio de Cristian Franco
                            </a>
                        </li>
                        <li>
                            <p class="text-gray-400">contacto@eduflow.com</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400 text-sm">
                <p>© {{ date('Y') }} EduFlow. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    @livewire('ui.floating-chatbot')

    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/alpinejs" defer></script>
    @stack('scripts')
</body>

</html>