<div>
    {{-- Notificación de mensaje Flash --}}
    @if (session()->has('message'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md mb-6" role="alert">
        <p>{{ session('message') }}</p>
    </div>
    @endif

    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $project->title }}</h1>
            <div class="flex items-center mt-2 space-x-4">
                <span class="text-sm text-gray-500">{{ $project->start_date->format('d M Y') }} - {{ $project->end_date->format('d M Y') }}</span>
            </div>
        </div>
        @can('update', $project)
        <a href="{{ route('student.projects.edit', $project) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">Editar Proyecto</a>
        @endcan
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Columna principal -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Descripción -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Descripción</h2>
                <div class="prose max-w-none text-gray-600">{!! nl2br(e($project->description)) !!}</div>
            </div>

            <!-- Tareas -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Tablero de Tareas</h2>
                @livewire('tasks.task-form', ['project' => $project], key('task-form-'.$project->id))
                @livewire('projects.kanban-board', ['project' => $project], key('kanban-board-'.$project->id))
            </div>
        </div>

        <!-- Columna lateral -->
        <div class="space-y-8">
            <!-- Progreso -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Progreso del Proyecto</h2>
                <p class="text-3xl font-bold">{{ $project->progress }}%</p>
                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                    <div class="bg-education-primary h-2.5 rounded-full" style="width: {{ $project->progress }}%"></div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Archivos del Proyecto</h3>

                <form wire:submit="uploadFiles" class="mb-6">
                    <div class="border border-dashed border-gray-300 rounded-lg p-4 text-center">
                        {{-- Indicador de carga --}}
                        <div wire:loading wire:target="files" class="w-full">
                            <p class="text-sm text-gray-500">Cargando archivos...</p>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                <div class="bg-education-primary h-2.5 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>

                        {{-- Input para subir archivos (se oculta durante la carga) --}}
                        <div wire:loading.remove wire:target="files">
                            <input type="file" wire:model="files" id="{{ $fileInputId }}" class="sr-only" multiple>
                            <label for="{{ $fileInputId }}" class="cursor-pointer text-education-primary hover:text-education-secondary font-semibold">
                                <span class="material-icons-outlined text-3xl">cloud_upload</span>
                                <span class="mt-2 block text-sm">Seleccionar archivos</span>
                            </label>
                        </div>
                    </div>

                    {{-- Previsualización de archivos a subir --}}
                    @if ($files)
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-700 mb-2">Archivos listos para subir:</p>
                        <ul class="text-sm text-gray-600 list-disc list-inside space-y-1">
                            @foreach($files as $file)
                            <li>{{ $file->getClientOriginalName() }} ({{ round($file->getSize() / 1024, 2) }} KB)</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @error('files.*') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror

                    {{-- El botón solo se activa si hay archivos seleccionados --}}
                    @if ($files)
                    <button type="submit" class="mt-4 w-full bg-education-primary hover:bg-education-secondary text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                        Subir {{ count($files) }} Archivo(s)
                    </button>
                    @endif
                </form>

                {{-- Lista de archivos existentes --}}
                <h4 class="text-lg font-semibold text-gray-700 mb-2 border-t pt-4">Archivos Adjuntos</h4>
                <div class="space-y-3">
                    @forelse($project->files as $file)
                    <div wire:key="file-{{ $file->id }}" class="flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 rounded-md transition-colors">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <span class="material-icons-outlined text-gray-500 flex-shrink-0">{{ $file->icon }}</span>
                            <a href="{{ $file->file_url }}" class="text-sm font-medium text-gray-800 hover:underline truncate" title="{{ $file->original_name }}" download>
                                {{ $file->original_name }}
                            </a>
                        </div>
                        <button
                            wire:click="deleteFile({{ $file->id }})"
                            wire:confirm="¿Estás seguro de que quieres eliminar '{{ $file->original_name }}'?"
                            class="text-gray-400 hover:text-red-600 p-1 rounded-full flex-shrink-0">
                            <span class="material-icons-outlined text-base">delete</span>
                        </button>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 text-center py-4">No hay archivos adjuntos en este proyecto.</p>
                    @endforelse
                </div>
            </div>

            <!-- Feedback -->
            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Feedback y Comentarios</h3>
                <form wire:submit="addFeedback" class="mb-6">
                    <textarea wire:model="feedbackContent" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Escribe un comentario..."></textarea>
                    @error('feedbackContent') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    <button type="submit" class="mt-2 w-full bg-education-primary text-white font-semibold py-2 px-4 rounded-lg">Enviar</button>
                </form>
                <div class="space-y-4">
                    @forelse($project->feedbacks as $feedback)
                    <div wire:key="feedback-{{ $feedback->id }}" class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-600">{{ strtoupper(substr($feedback->user->name, 0, 1)) }}</div>
                        <div class="flex-1 bg-gray-50 p-3 rounded-lg">
                            <div class="flex justify-between items-center">
                                <p class="font-semibold text-sm">{{ $feedback->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $feedback->created_at->diffForHumans() }}</p>
                            </div>
                            <p class="text-sm text-gray-700 mt-1 whitespace-pre-wrap">{{ $feedback->content }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 text-center py-4">No hay comentarios todavía.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>