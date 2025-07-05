<div>
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Iniciar Sesión</h2>
    
    <form wire:submit.prevent="login">
        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700">Correo Electrónico</label>
            <input wire:model="email" id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="email" name="email" required autofocus autocomplete="username" />
            @error('email') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700">Contraseña</label>
            <input wire:model="password" id="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="password" name="password" required autocomplete="current-password" />
            @error('password') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="remember" id="remember" type="checkbox" class="rounded border-gray-300 text-education-primary shadow-sm focus:ring-education-primary" name="remember">
                <span class="ml-2 text-sm text-gray-600">Recordarme</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            {{-- En un futuro, podrías añadir un link a una página de olvido de contraseña --}}
            {{-- <a class="underline text-sm text-gray-600 hover:text-gray-900" href="#"> --}}
            {{--     ¿Olvidaste tu contraseña? --}}
            {{-- </a> --}}

            <button type="submit" class="ml-3 inline-flex items-center px-4 py-2 bg-education-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-education-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-education-primary transition ease-in-out duration-150">
                Iniciar Sesión
            </button>
        </div>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                ¿No tienes una cuenta?
                <a href="{{ route('register') }}" class="font-medium text-education-primary hover:text-education-secondary">
                    Regístrate aquí
                </a>
            </p>
        </div>
    </form>
</div>