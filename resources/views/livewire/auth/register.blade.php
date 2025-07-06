@section('title', 'Crear Cuenta')
@section('form-title', 'Crea una nueva cuenta')
@section('form-subtitle')
    ¿Ya tienes una cuenta? <a href="{{ route('login') }}" wire:navigate class="font-semibold text-education-primary hover:text-education-secondary">Inicia sesión aquí</a>.
@endsection

<div>
    <form wire:submit.prevent="register" class="space-y-6">
        <div>
            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Nombre Completo</label>
            <div class="mt-2">
                <input wire:model.lazy="name" id="name" name="name" type="text" autocomplete="name" required class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-education-primary sm:text-sm sm:leading-6">
            </div>
            @error('name') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
        </div>

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
                <input wire:model.lazy="password" id="password" name="password" type="password" autocomplete="new-password" required class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-education-primary sm:text-sm sm:leading-6">
            </div>
            @error('password') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium leading-6 text-gray-900">Confirmar Contraseña</label>
            <div class="mt-2">
                <input wire:model.lazy="password_confirmation" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-education-primary sm:text-sm sm:leading-6">
            </div>
        </div>

        <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-education-primary px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-education-secondary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-education-primary" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="register">
                    Crear Cuenta
                </span>
                <span wire:loading wire:target="register">
                    Creando...
                </span>
            </button>
        </div>
    </form>
</div>