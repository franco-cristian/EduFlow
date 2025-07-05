<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTrack Pro - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-education-primary text-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h1 class="text-xl font-bold">EduTrack Pro</h1>
            </div>

            <!-- Navegación -->
            <nav class="hidden md:block">
                <ul class="flex space-x-6">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-education-secondary transition">Inicio</a></li>
                    @auth
                    <li><a href="{{ route(auth()->user()->role . '.projects.index') }}" class="hover:text-education-secondary transition">Proyectos</a></li>
                    <li><a href="{{ route('ai.assistant') }}" class="hover:text-education-secondary transition">Asistente IA</a></li>
                    @endauth
                </ul>
            </nav>

            <!-- Usuario -->
            @auth
            <div class="flex items-center space-x-4">
                <div class="relative group">
                    <button class="flex items-center space-x-2 focus:outline-none">
                        <div class="w-8 h-8 rounded-full bg-education-secondary flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="hidden lg:inline">{{ auth()->user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 hidden group-hover:block z-50">
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Perfil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">Cerrar sesión</button>
                        </form>
                    </div>
                </div>
            </div>
            @else
            <div class="flex space-x-4">
                <a href="{{ route('login') }}" class="px-4 py-2 rounded hover:bg-education-secondary transition">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-white text-education-primary rounded font-medium hover:bg-gray-100 transition">Registrarse</a>
            </div>
            @endauth

            <!-- Menú móvil -->
            <button class="md:hidden text-white focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">EduTrack Pro</h3>
                    <p class="text-gray-400">Plataforma de gestión de proyectos académicos para instituciones educativas.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Enlaces</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Documentación</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Soporte</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Política de privacidad</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contacto</h3>
                    <p class="text-gray-400">contacto@edutrackpro.edu</p>
                    <p class="text-gray-400">+1 (234) 567-890</p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} EduTrack Pro. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
    @livewire('floating-chatbot')
    @stack('scripts')
</body>

</html>