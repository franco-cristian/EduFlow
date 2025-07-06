<x-card>
    <x-slot name="header">
        <h3 class="text-lg font-semibold">{{ $isEditing ? 'Editar Proyecto' : 'Crear Nuevo Proyecto' }}</h3>
    </x-slot>

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Título -->
            <div class="md:col-span-2">
                <label for="title" class="block text-sm font-medium text-gray-700">Título del Proyecto</label>
                <input type="text" wire:model.lazy="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Descripción -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea wire:model.lazy="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Fecha de Inicio -->
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                <input type="date" wire:model.lazy="start_date" id="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Fecha de Fin -->
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Fecha de Entrega</label>
                <input type="date" wire:model.lazy="end_date" id="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                @error('end_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            
            <!-- Estado -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                <select wire:model.lazy="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="planning">Planificación</option>
                    <option value="in_progress">En Progreso</option>
                    <option value="completed">Completado</option>
                </select>
                @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Asignar Profesor -->
            <div>
                <label for="teacher_id" class="block text-sm font-medium text-gray-700">Asignar Profesor (Opcional)</label>
                <select wire:model.lazy="teacher_id" id="teacher_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Sin asignar</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach
                </select>
                @error('teacher_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Archivos -->
            <div class="md:col-span-2">
                <label for="files" class="block text-sm font-medium text-gray-700">Subir Archivos (Opcional)</label>
                <input type="file" wire:model="files" id="files" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <div wire:loading wire:target="files" class="text-sm text-gray-500 mt-1">Cargando...</div>
                @error('files.*') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

        </div>
    </form>

    <x-slot name="footer">
        <div class="flex justify-end space-x-4">
            <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md">Cancelar</a>
            <button type="button" wire:click.prevent="save" class="px-4 py-2 bg-education-primary text-white rounded-md" wire:loading.attr="disabled">
                {{ $isEditing ? 'Actualizar Proyecto' : 'Guardar Proyecto' }}
            </button>
        </div>
    </x-slot>
</x-card>