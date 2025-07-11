<div>
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Todos los Proyectos</h1>
    
    <div class="mb-4">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar por título..." class="form-input rounded-md border-gray-300 shadow-sm w-full md:w-1/3">
    </div>

    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase">Proyecto</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase">Estudiante</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase">Profesor</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 uppercase">Estado</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($projects as $project)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $project->title }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $project->user->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $project->teacher->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4"><x-badge :status="$project->status" /></td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('projects.show', $project) }}" class="font-medium text-education-primary hover:underline">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-10 text-gray-500">No se encontraron proyectos.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($projects->hasPages())
            <div class="p-4 bg-gray-50 border-t">{{ $projects->links() }}</div>
        @endif
    </div>
</div>