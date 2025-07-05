<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function login()
    {
        $validated = $this->validate();

        if (!Auth::attempt($validated, $this->remember)) {
            // Si la autenticación falla, añade un error específico al campo de email.
            $this->addError('email', 'Las credenciales proporcionadas no coinciden con nuestros registros.');
            return;
        }

        // Regenera la sesión para prevenir "session fixation"
        request()->session()->regenerate();

        // Redirige al dashboard
        return redirect()->intended(route('dashboard'));
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.guest');
    }
}