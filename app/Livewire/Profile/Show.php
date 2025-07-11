<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Show extends Component
{
    public function render()
    {
        return view('livewire.profile.show')
            ->title('Mi Perfil');
    }
}