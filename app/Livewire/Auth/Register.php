<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth; // <-- Importante: Usar el Facade Auth
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Livewire\Component;
use Livewire\Attributes\Layout; // <-- Importar el atributo de Layout

#[Layout('layouts.guest')] // <-- Usar el atributo aquí
class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function register()
    {
        $validated = $this->validate();

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            // El rol 'student' se asigna por defecto desde la migración.
        ]);

        event(new Registered($user));

        // Corregido: Usar el Facade Auth para iniciar sesión
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        // Ya no se necesita ->layout() aquí
        return view('livewire.auth.register');
    }
}