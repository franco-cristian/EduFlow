<div>
    <div class="relative flex h-screen items-center bg-gray-50 px-4">
        <div class="relative mx-auto w-full max-w-4xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center bg-white shadow-xl rounded-2xl p-8">
                <!-- Imagen con efecto hover -->
                <div class="hidden md:block relative group h-full">
                    <img alt="Fondo educativo" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBBDqu2bxUbPyhAZyCnft70lC5CT3kYtZKzZHD23RlfuJ5op5KoTXIKcNJqrW745rtu_1vz9ROtKW0PRvovfLgSohzZ8wV9Zt4m3s3TesuraiC-F-wYVBqIQdni6yTi4QtXbduOHoBufM9torLuIKFw06O5eCZSVzvA1kytVa8cP1b4noUfqGnZ_1CAuvcogyOiinT4tU_9gm4FhmN43gOwtrFsRmNnba-mZSPamBFFo81G__7YO_T46CQrnqTVl5yxqpotcbL3F28"
                        class="rounded-lg object-cover w-full h-full transform transition-transform duration-500 group-hover:scale-105" />
                    <div class="absolute inset-0 bg-black bg-opacity-20 rounded-lg group-hover:bg-opacity-10 transition-opacity duration-300"></div>
                </div>

                <!-- Formulario -->
                <div class="flex flex-col justify-center">
                    <div class="flex flex-col items-center text-center mb-8">
                        <div class="flex items-center gap-2 justify-center text-gray-800">
                            <svg class="h-8 w-8 text-education-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <h1 class="text-2xl font-bold tracking-tight">EduFlow</h1>
                        </div>
                        <h2 class="mt-2 text-xl font-semibold text-gray-900">Crea tu cuenta</h2>
                        <p class="mt-2 text-sm text-gray-500">Únete a EduFlow y gestiona tus proyectos académicos.</p>
                    </div>

                    <form wire:submit="register" class="space-y-5">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre completo</label>
                            <input wire:model="name" type="text" id="name" name="name" required autocomplete="name" placeholder="Germán Crozy"
                                class="mt-1 block w-full rounded-md border-0 py-2.5 px-4 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                            <input wire:model="email" type="email" id="email" name="email" required autocomplete="email" placeholder="tu@ejemplo.com"
                                class="mt-1 block w-full rounded-md border-0 py-2.5 px-4 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                            <input wire:model="password" type="password" id="password" name="password" required autocomplete="new-password" placeholder="••••••••"
                                class="mt-1 block w-full rounded-md border-0 py-2.5 px-4 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                            @error('password') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                            <input wire:model="password_confirmation" type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••"
                                class="mt-1 block w-full rounded-md border-0 py-2.5 px-4 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                        </div>

                        <div>
                            <button type="submit"
                                class="flex w-full justify-center rounded-md bg-education-primary px-3 py-3 text-sm font-semibold text-white shadow-sm hover:bg-education-secondary focus:outline-none focus:ring-2 focus:ring-education-primary focus:ring-offset-2">
                                <span wire:loading.remove>Registrarse</span>
                                <span wire:loading>Creando cuenta...</span>
                            </button>
                        </div>
                    </form>

                    <p class="mt-8 text-center text-sm text-gray-500">
                        ¿Ya tienes una cuenta?
                        <a href="{{ route('login') }}" wire:navigate class="font-semibold text-education-primary hover:text-education-secondary">Inicia sesión</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>