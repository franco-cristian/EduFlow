@section('title', 'Iniciar Sesión')
@section('form-title', 'Inicia sesión en tu cuenta')
@section('form-subtitle')
    ¿No tienes una cuenta? <a href="{{ route('register') }}" wire:navigate class="font-semibold text-education-primary hover:text-education-secondary">Empieza ahora</a>.
@endsection

<div>
    <form wire:submit.prevent="login" class="space-y-6">
        <div>
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Correo Electrónico</label>
            <div class="mt-2">
                <input wire:model.lazy="email" id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-education-primary sm:text-sm sm:leading-6">
            </div>
            @error('email') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Contraseña</label>
            <div class="mt-2">
                <input wire:model.lazy="password" id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-education-primary sm:text-sm sm:leading-6">
            </div>
             @error('password') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input wire:model.lazy="remember" id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-education-primary focus:ring-education-primary">
                <label for="remember-me" class="ml-3 block text-sm leading-6 text-gray-900">Recordarme</label>
            </div>

            <div class="text-sm leading-6">
                {{-- <a href="#" class="font-semibold text-education-primary hover:text-education-secondary">¿Olvidaste tu contraseña?</a> --}}
            </div>
        </div>

        <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-education-primary px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-education-secondary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-education-primary" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="login">
                    Iniciar Sesión
                </span>
                <span wire:loading wire:target="login">
                    Procesando...
                </span>
            </button>
        </div>
    </form>
</div>