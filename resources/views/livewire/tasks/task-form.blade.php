<div>
    {{-- Botón para abrir el modal --}}
    <div class="mb-4 text-right">
        <button wire:click="openModal" class="inline-flex items-center px-4 py-2 bg-education-primary text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-education-secondary">
            <span class="material-icons-outlined text-base mr-1">add</span>
            Nueva Tarea
        </button>
    </div>

    {{-- Modal --}}
    @if($showModal)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg" @click.away="$wire.showModal = false">
            <h3 class="text-xl font-bold mb-4">{{ $isEditing ? 'Editar Tarea' : 'Crear Nueva Tarea' }}</h3>

            <form wire:submit="save">
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                        <input wire:model="title" type="text" id="title" class="mt-1 block w-full form-input rounded-md border-gray-300 shadow-sm">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <textarea wire:model="description" id="description" rows="3" class="mt-1 block w-full form-input rounded-md border-gray-300 shadow-sm"></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                         <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700">Fecha Límite</label>
                            <input wire:model="due_date" type="date" id="due_date" class="mt-1 block w-full form-input rounded-md border-gray-300 shadow-sm">
                            @error('due_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                            <select wire:model="status" id="status" class="mt-1 block w-full form-select rounded-md border-gray-300 shadow-sm">
                                <option value="todo">Por Hacer</option>
                                <option value="in_progress">En Progreso</option>
                                <option value="completed">Completado</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" @click="$wire.showModal = false" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg">Cancelar</button>
                    <button type="submit" class="bg-education-primary text-white px-4 py-2 rounded-lg">{{ $isEditing ? 'Actualizar' : 'Guardar' }}</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>