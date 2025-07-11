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
    <div class="min-h-screen flex flex-col">
        <header x-data="{ mobileMenuOpen: false }" class="bg-education-primary shadow-md sticky top-0 z-30">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex-shrink-0 flex items-center space-x-2 text-white">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span class="text-xl font-bold">EduFlow</span>
                        </a>
                    </div>

                    <!-- Navegación y Menú de Usuario -->
                    <div class="flex items-center">
                        <!-- Navegación Desktop -->
                        <nav class="hidden md:flex items-center space-x-4">
                            @auth
                                {{-- Menú para Admin --}}
                                @if (auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                                    <a href="{{ route('admin.users.index') }}" class="text-white hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">Usuarios</a>
                                    <a href="{{ route('admin.projects.index') }}" class="text-white hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">Proyectos</a>
                                
                                {{-- Menú para Profesor --}}
                                @elseif (auth()->user()->isTeacher())
                                    <a href="{{ route('teacher.dashboard') }}" class="text-white hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">Mis Proyectos</a>
                                    {{-- Aquí podrían ir más enlaces para el profesor --}}
                                
                                {{-- Menú para Estudiante (por defecto) --}}
                                @else
                                    <a href="{{ route('student.dashboard') }}" class="text-white hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">Inicio</a>
                                    <a href="{{ route('student.projects.index') }}" class="text-white hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">Proyectos</a>
                                @endif
                                
                                {{-- Botón común para todos los roles autenticados --}}
                                <button @click="$dispatch('toggle-chatbot')" class="text-white hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">Asistente IA</button>
                            @endauth
                        </nav>

                        <!-- Menú de Usuario -->
                        <div x-data="{ userMenuOpen: false }" class="relative ml-4">
                            <button @click="userMenuOpen = !userMenuOpen" class="flex items-center text-sm rounded-full text-white focus:outline-none">
                                <div class="h-8 w-8 rounded-full bg-education-secondary flex items-center justify-center font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                            </button>
                            <div x-show="userMenuOpen" @click.away="userMenuOpen = false" x-transition x-cloak class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-50">
                                <div class="px-4 py-3 border-b">
                                    <p class="text-sm font-semibold text-gray-700">Hola, {{ auth()->user()->name }}</p>
                                </div>
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mi Perfil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf<button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cerrar sesión</button>
                                </form>
                            </div>
                        </div>

                        <!-- Botón Hamburguesa -->
                        <div class="-mr-2 flex md:hidden ml-2">
                            <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-education-secondary focus:outline-none">
                                <span class="sr-only">Abrir menú</span>
                                <svg x-show="!mobileMenuOpen" class="h-6 w-6 block" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                                <svg x-show="mobileMenuOpen" class="h-6 w-6 block" stroke="currentColor" fill="none" viewBox="0 0 24 24" x-cloak>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menú Móvil -->
            <div x-show="mobileMenuOpen" class="md:hidden" x-cloak>
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
                            <a href="{{ route('admin.users.index') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Usuarios</a>
                            <a href="{{ route('admin.projects.index') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Proyectos</a>
                        @elseif (auth()->user()->isTeacher())
                            <a href="{{ route('teacher.dashboard') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Mis Proyectos</a>
                        @else
                            <a href="{{ route('student.dashboard') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Inicio</a>
                            <a href="{{ route('student.projects.index') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Proyectos</a>
                        @endif
                        <button @click="$dispatch('toggle-chatbot'); mobileMenuOpen = false" class="text-gray-300 hover:bg-gray-700 hover:text-white block w-full text-left px-3 py-2 rounded-md text-base font-medium">Asistente IA</button>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Contenido principal -->
        <main class="flex-grow">
            <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
                {{ $slot ?? $__env->yieldContent('content') }}
            </div>
        </main>

        <!-- Footer -->
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
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Desarrollador</h3>
                        <ul class="space-y-2">
                            <li><a href="https://franco-cristian.github.io/" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition">Ver Portafolio de Cristian Franco</a></li>
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
    </div>

    @livewire('ui.floating-chatbot')

    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/alpinejs" defer></script>
    @stack('scripts')
</body>

</html>