<div>
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Crear una Cuenta</h2>

    <form wire:submit.prevent="register">
        <!-- Name -->
        <div>
            <label for="name" class="block font-medium text-sm text-gray-700">Nombre Completo</label>
            <input wire:model="name" id="name" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" required autofocus autocomplete="name" />
            @error('name') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email" class="block font-medium text-sm text-gray-700">Correo Electrónico</label>
            <input wire:model="email" id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="email" required autocomplete="username" />
            @error('email') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700">Contraseña</label>
            <input wire:model="password" id="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="password" required autocomplete="new-password" />
            @error('password') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirmar Contraseña</label>
            <input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="password" name="password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-education-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-education-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-education-primary transition ease-in-out duration-150">
                Registrarse
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="font-medium text-education-primary hover:text-education-secondary">
                    Inicia sesión aquí
                </a>
            </p>
        </div>
    </form>
</div>