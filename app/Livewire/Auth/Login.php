<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest')]
class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected function rules(): array
    {
        return [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function login()
    {
        $credentials = $this->validate();

        if (!Auth::attempt($credentials, $this->remember)) {
            $this->addError('email', 'Las credenciales proporcionadas no coinciden con nuestros registros.');
            return;
        }

        request()->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function render()
    {
        // Ya no se necesita ->layout() aquí
        return view('livewire.auth.login');
    }
}