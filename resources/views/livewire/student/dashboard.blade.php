<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Encabezado y Botón de Nuevo Proyecto --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10">
        <h2 class="text-4xl font-bold text-gray-800 mb-4 md:mb-0">
            Bienvenido, {{ auth()->user()->name }}
        </h2>
        <a href="{{ route('student.projects.create') }}" 
           class="flex items-center bg-education-primary hover:bg-education-secondary text-white font-semibold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
            <span class="material-icons-outlined mr-2">add</span>
            Nuevo Proyecto
        </a>
    </div>

    {{-- Tarjetas de Estadísticas (Stats Cards) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        
        {{-- Tarjeta 1: Proyectos Activos --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-100 rounded-full">
                    <span class="material-icons-outlined text-blue-500">inventory_2</span>
                </div>
            </div>
            <div>
                <p class="text-gray-500 text-base mb-1">Proyectos Activos</p>
                <p class="text-4xl font-bold text-gray-800">{{ $activeProjects }}</p>
            </div>
        </div>

        {{-- Tarjeta 2: Tareas Pendientes --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <span class="material-icons-outlined text-yellow-500">pending_actions</span>
                </div>
            </div>
            <div>
                <p class="text-gray-500 text-base mb-1">Tareas Pendientes</p>
                <p class="text-4xl font-bold text-gray-800">{{ $pendingTasks }}</p>
            </div>
        </div>

        {{-- Tarjeta 3: Proyectos Completados --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-100 rounded-full">
                    <span class="material-icons-outlined text-green-500">check_circle_outline</span>
                </div>
            </div>
            <div>
                <p class="text-gray-500 text-base mb-1">Proyectos Completados</p>
                <p class="text-4xl font-bold text-gray-800">{{ $completedProjects }}</p>
            </div>
        </div>
    </div>

    {{-- Sección de Proyectos Recientes --}}
<section>
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-2xl font-bold text-gray-800">Mis Proyectos Recientes</h3>
        <a href="{{ route('student.projects.index') }}" class="text-sm font-semibold text-education-primary hover:underline">
            Ver todos los proyectos
        </a>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            @if($projects->isEmpty())
                {{-- Estado Vacío --}}
                <div class="text-center py-16 px-6">
                    <span class="material-icons-outlined text-5xl text-gray-400 mb-4">folder_off</span>
                    <p class="text-gray-500 mb-6 text-lg">Aún no has creado ningún proyecto.</p>
                    <a href="{{ route('student.projects.create') }}" 
                       class="inline-flex items-center bg-education-primary hover:bg-education-secondary text-white font-semibold py-2 px-5 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                        Crea tu primer proyecto
                    </a>
                </div>
            @else
                {{-- Tabla de Proyectos --}}
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase tracking-wider">Nombre del Proyecto</th>
                            <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase tracking-wider">Progreso</th>
                            <th class="relative px-6 py-3"><span class="sr-only">Ver</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($projects as $project)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('projects.show', $project) }}" class="font-medium text-gray-900 hover:text-education-primary">
                                        {{ $project->title }}
                                    </a>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Vence: {{ $project->end_date->format('d M, Y') }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-education-primary h-2 rounded-full" style="width: {{ $project->progress }}%"></div>
                                        </div>
                                        <span class="font-medium text-sm text-gray-600">{{ $project->progress }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('projects.show', $project) }}" class="text-education-primary hover:text-education-secondary">Ver</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        @if($projects->hasPages())
            <div class="p-4 bg-gray-50 border-t border-gray-200">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</section>
</div>