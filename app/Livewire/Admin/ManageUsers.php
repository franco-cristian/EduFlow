<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ManageUsers extends Component
{
    use WithPagination;

    public $search = '';
    public $roles = ['student', 'teacher', 'admin'];

    public function updateRole($userId, $newRole)
    {
        // Validamos que el rol sea uno de los permitidos
        if (!in_array($newRole, $this->roles)) {
            return;
        }

        $user = User::find($userId);
        if ($user) {
            $user->role = $newRole;
            $user->save();
            session()->flash('message', 'Rol de ' . $user->name . ' actualizado a ' . $newRole . '.');
        }
    }
    
    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('email', 'like', '%'.$this->search.'%');
            });
        }
        
        return view('livewire.admin.manage-users', [
            'users' => $query->paginate(15)
        ])->title('Gestionar Usuarios');
    }
}