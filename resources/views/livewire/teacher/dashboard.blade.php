<div>
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Panel del Profesor</h1>

    {{-- Tarjetas de Estadísticas --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow"><p class="text-sm text-gray-500">Total de Proyectos Supervisados</p><p class="text-2xl font-bold">{{ $totalSupervised }}</p></div>
        <div class="bg-white p-6 rounded-lg shadow"><p class="text-sm text-gray-500">En Progreso</p><p class="text-2xl font-bold">{{ $inProgressSupervised }}</p></div>
        <div class="bg-white p-6 rounded-lg shadow"><p class="text-sm text-gray-500">Completados</p><p class="text-2xl font-bold">{{ $completedSupervised }}</p></div>
    </div>
    
    {{-- Tabla de Proyectos Supervisados --}}
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-4"><h3 class="font-semibold">Proyectos a mi cargo</h3></div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase">Proyecto</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase">Estudiante</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase">Estado</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase">Progreso</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($projects as $project)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $project->title }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $project->user->name }}</td>
                            <td class="px-6 py-4"><x-badge :status="$project->status" /></td>
                            <td class="px-6 py-4">
                                <div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-education-primary h-2 rounded-full" style="width: {{ $project->progress }}%"></div></div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                {{-- El profesor es redirigido a la misma vista 'show' del estudiante, pero con permisos de profesor --}}
                                <a href="{{ route('projects.show', $project) }}" class="font-medium text-education-primary hover:underline">Revisar</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-10 text-gray-500">No tienes proyectos asignados para supervisar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($projects->hasPages())
            <div class="p-4 bg-gray-50 border-t">{{ $projects->links() }}</div>
        @endif
    </div>
</div>