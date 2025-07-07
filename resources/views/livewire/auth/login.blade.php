<div>
    <div class="flex h-screen items-center bg-gray-50 px-4">
        <div class="mx-auto w-full max-w-4xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center bg-white shadow-xl rounded-2xl p-8">
                <!-- Formulario -->
                <div class="flex flex-col justify-center">
                    <div class="flex flex-col items-center text-center mb-8">
                        <div class="flex items-center gap-2">
                            <svg class="h-8 w-8 text-education-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <h2 class="text-2xl font-bold tracking-tight text-gray-900">EduFlow</h2>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">¡Bienvenido de nuevo! Ingresa tus credenciales.</p>
                    </div>


                    <form wire:submit="login" class="space-y-5">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                            <input wire:model="email" type="email" id="email" name="email" required autocomplete="email" placeholder="tu@ejemplo.com"
                                class="mt-1 block w-full rounded-md border-0 py-2.5 px-4 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                            <input wire:model="password" type="password" id="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                                class="mt-1 block w-full rounded-md border-0 py-2.5 px-4 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input wire:model="remember" id="remember-me" name="remember-me" type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-education-primary focus:ring-education-primary" />
                                <label for="remember-me" class="ml-2 block text-sm text-gray-600">
                                    Recuérdame
                                </label>
                            </div>
                            <div class="text-sm">
                                <a href="#" class="font-medium text-education-primary hover:text-education-secondary">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="flex w-full justify-center rounded-md bg-education-primary px-3 py-3 text-sm font-semibold text-white shadow-sm hover:bg-education-secondary focus:outline-none focus:ring-2 focus:ring-education-primary focus:ring-offset-2">
                                <span wire:loading.remove>Iniciar sesión</span>
                                <span wire:loading>Ingresando...</span>
                            </button>
                        </div>
                    </form>

                    <p class="mt-8 text-center text-sm text-gray-500">
                        ¿No tienes una cuenta?
                        <a href="{{ route('register') }}" wire:navigate class="font-semibold text-education-primary hover:text-education-secondary">Regístrate</a>
                    </p>
                </div>

                <!-- Imagen con efecto hover -->
                <div class="hidden md:block relative group h-full">
                    <img alt="Estudiantes colaborando en un aula" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB79r8w8LEWMJT0Beyt7JNqxmKvxwHIE3EI5fCIBnsWtTEfl_-AbiojobgldFyggzaFzCsIo7Xggk0MTH3VZmdLxjRV4gra7fdKO6SR2krYA7sUTtPY7P90MIXKJwTXQpdPbldG9kFnZuC3M0cuFop29tGwX2JcO7eSpXtuTs_L95lLwJ9qW5N9jKEMPvsLQR16NzTmpEc57EfOjTDdzkCuXvGSb4jLiN0l05y6opAVy40aypNIHxhXu0eMpHC1RccL6rU9oH67KG0k"
                        class="rounded-lg object-cover w-full h-full transform transition-transform duration-500 group-hover:scale-105" />
                    <div class="absolute inset-0 bg-black bg-opacity-20 rounded-lg group-hover:bg-opacity-10 transition-opacity duration-300"></div>
                </div>
            </div>
        </div>
    </div>
</div>