<div>
    {{-- Notificación de mensaje Flash --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md mb-6" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Mis Proyectos</h1>
        <a href="{{ route('student.projects.create') }}" 
           class="inline-flex items-center bg-education-primary hover:bg-education-secondary text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300">
            <span class="material-icons-outlined mr-2 text-base">add</span>
            Nuevo Proyecto
        </a>
    </div>

    {{-- Barra de Filtros --}}
    <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar por nombre de proyecto..." class="form-input rounded-md border-gray-300 shadow-sm w-full focus:ring-education-primary focus:border-education-primary">
            <select wire:model.live="statusFilter" class="form-select rounded-md border-gray-300 shadow-sm w-full focus:ring-education-primary focus:border-education-primary">
                <option value="">Todos los estados</option>
                <option value="planning">Planificación</option>
                <option value="in_progress">En Progreso</option>
                <option value="completed">Completado</option>
            </select>
        </div>
    </div>
    
    {{-- Tabla de Proyectos --}}
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase tracking-wider">Proyecto</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase tracking-wider">Progreso</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase tracking-wider text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($projects as $project)
                        <tr wire:key="project-{{ $project->id }}">
                            <td class="px-6 py-4">
                                <a href="{{ route('projects.show', $project) }}" class="font-medium text-gray-900 hover:text-education-primary">{{ $project->title }}</a>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'planning' => 'bg-blue-100 text-blue-800',
                                        'in_progress' => 'bg-yellow-100 text-yellow-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                    ];
                                @endphp
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $statusClasses[$project->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ Str::ucfirst(str_replace('_', ' ', $project->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-education-primary h-2 rounded-full" style="width: {{ $project->progress }}%"></div></div>
                                    <span class="font-medium text-sm text-gray-600">{{ $project->progress }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                {{-- BOTONES DE ACCIÓN CORREGIDOS --}}
                                <button wire:click="editProject({{ $project->id }})" class="font-medium text-education-primary hover:underline">Editar</button>
                                <span class="text-gray-300 mx-1">|</span>
                                <button 
                                    wire:click="deleteProject({{ $project->id }})" 
                                    wire:confirm="¿Estás seguro de que quieres eliminar '{{ $project->title }}'? Esta acción es irreversible."
                                    class="font-medium text-red-600 hover:underline">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-12 px-6">
                                <p class="text-gray-500">No se encontraron proyectos con los filtros actuales.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($projects->hasPages())
        <div class="p-4 bg-gray-50 border-t">
            {{ $projects->links() }}
        </div>
        @endif
    </div>
</div>