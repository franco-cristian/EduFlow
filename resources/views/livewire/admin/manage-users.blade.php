<div>
    {{-- Notificación --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md mb-6" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Gestionar Usuarios</h1>

    {{-- Barra de Búsqueda --}}
    <div class="mb-4">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar por nombre o email..." class="form-input rounded-md border-gray-300 shadow-sm w-full md:w-1/3">
    </div>

    {{-- Tabla de Usuarios --}}
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase">Email</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase">Rol</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase">Miembro Desde</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr wire:key="user-{{ $user->id }}">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{-- Menú desplegable para cambiar el rol --}}
                                <select 
                                    wire:change="updateRole({{ $user->id }}, $event.target.value)"
                                    class="form-select rounded-md border-gray-300 shadow-sm text-sm"
                                    {{ auth()->id() == $user->id ? 'disabled' : '' }} {{-- Un admin no puede cambiar su propio rol --}}
                                >
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>
                                            {{ ucfirst($role) }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('d M, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-12 px-6 text-gray-500">
                                No se encontraron usuarios.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="p-4 bg-gray-50 border-t">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>