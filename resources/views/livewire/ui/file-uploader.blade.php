<div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Archivos del Proyecto</h3>

    {{-- Formulario para subir archivos --}}
    <form wire:submit="save" class="mb-6">
        <div class="border border-dashed border-gray-300 rounded-lg p-4 text-center">
            <input type="file" wire:model="files" id="file-upload-{{ $this->id }}" class="sr-only" multiple>
            <label for="file-upload-{{ $this->id }}" class="cursor-pointer text-education-primary hover:text-education-secondary font-semibold">
                <span class="material-icons-outlined text-3xl">cloud_upload</span>
                <span class="mt-2 block text-sm">Seleccionar archivos para subir</span>
            </label>
            <div wire:loading wire:target="files" class="text-sm text-gray-500 mt-2">Cargando...</div>
        </div>
        @if ($files)
            <ul class="mt-3 text-sm text-gray-600 list-disc list-inside">
                @foreach($files as $file)
                    <li>{{ $file->getClientOriginalName() }}</li>
                @endforeach
            </ul>
        @endif
        @error('files.*') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror

        <button type="submit" class="mt-4 w-full bg-education-primary hover:bg-education-secondary text-white font-semibold py-2 px-4 rounded-lg transition-colors">
            Subir Archivos
        </button>
    </form>
    
    {{-- Lista de archivos existentes --}}
    <div class="space-y-3">
        @forelse($projectFiles as $file)
            <div wire:key="file-{{ $file->id }}" class="flex items-center justify-between p-3 bg-gray-50 rounded-md">
                <div class="flex items-center gap-3">
                    <span class="material-icons-outlined text-gray-500">{{ $file->icon }}</span>
                    <a href="{{ $file->file_url }}" class="text-sm font-medium text-gray-800 hover:underline" download>
                        {{ Str::limit($file->original_name, 25) }}
                    </a>
                </div>
                <button 
                    wire:click="deleteFile({{ $file->id }})" 
                    wire:confirm="¿Estás seguro de que quieres eliminar '{{ $file->original_name }}'?"
                    class="text-gray-400 hover:text-red-600">
                    <span class="material-icons-outlined text-base">delete</span>
                </button>
            </div>
        @empty
            <p class="text-sm text-gray-500 text-center py-4">No hay archivos adjuntos en este proyecto.</p>
        @endforelse
    </div>
</div>