<div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $columns = [
                'todo' => ['title' => 'Por Hacer', 'tasks' => $todoTasks, 'color' => 'text-gray-700'],
                'in_progress' => ['title' => 'En Progreso', 'tasks' => $inProgressTasks, 'color' => 'text-yellow-700'],
                'completed' => ['title' => 'Completado', 'tasks' => $completedTasks, 'color' => 'text-green-700'],
            ];
        @endphp

        @foreach ($columns as $status => $column)
            <div wire:key="column-{{ $status }}"
                 id="column-{{ $status }}"
                 class="bg-gray-100 rounded-lg p-4 space-y-4 min-h-[300px] border-2 border-dashed border-gray-200 transition-colors"
                 ondrop="drop(event)"
                 ondragover="allowDrop(event)"
                 ondragenter="handleDragEnter(event)"
                 ondragleave="handleDragLeave(event)">
                
                <div class="flex justify-between items-center pointer-events-none">
                    <h4 class="font-semibold {{ $column['color'] }}">{{ $column['title'] }}</h4>
                    <span class="bg-gray-200 text-gray-700 rounded-full px-3 py-1 text-sm font-semibold">
                        {{ count($column['tasks']) }}
                    </span>
                </div>
                
                @forelse ($column['tasks'] as $task)
                    <div wire:key="task-card-{{ $task->id }}"
                         id="{{ $task->id }}" 
                         class="bg-white rounded-lg shadow p-4 cursor-move" 
                         draggable="true" 
                         ondragstart="drag(event)">
                        
                        <div class="pointer-events-none">
                            <h5 class="font-semibold text-gray-800 {{ $task->status === 'completed' ? 'line-through' : '' }}">{{ $task->title }}</h5>
                            @if($task->description)
                                <p class="text-sm text-gray-600 mt-2">{{ Str::limit($task->description, 80) }}</p>
                            @endif
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-xs text-gray-500 flex items-center gap-1">
                                    <span class="material-icons-outlined text-sm">calendar_today</span>
                                    {{ \Carbon\Carbon::parse($task->due_date)->format('d M, Y') }}
                                </span>
                                @if($task->assignee)
                                    <span class="text-xs font-medium px-2 py-1 rounded-full bg-blue-100 text-blue-800">{{ $task->assignee->name }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-400 pt-10 text-sm pointer-events-none">Arrastra una tarea aquí.</div>
                @endforelse
            </div>
        @endforeach
    </div>

    {{-- Script de JavaScript Puro --}}
    @push('scripts')
    <script>
        function allowDrop(event) {
            event.preventDefault();
        }

        function handleDragEnter(event) {
            // Añade una clase para el feedback visual
            if (event.target.classList.contains('bg-gray-100')) {
                event.target.classList.remove('bg-gray-100');
                event.target.classList.add('bg-indigo-100');
            }
        }

        function handleDragLeave(event) {
            // Quita la clase para el feedback visual
            if (event.target.classList.contains('bg-indigo-100')) {
                event.target.classList.remove('bg-indigo-100');
                event.target.classList.add('bg-gray-100');
            }
        }

        function drag(event) {
            // Guarda el ID de la tarea que se está arrastrando
            event.dataTransfer.setData("text/plain", event.target.id);
        }

        function drop(event) {
            event.preventDefault();
            
            // Restaura el estilo de la columna
            handleDragLeave(event);

            const taskId = event.dataTransfer.getData("text/plain");
            const taskElement = document.getElementById(taskId);
            
            // Encuentra la columna de destino
            let columnElement = event.target;
            while(columnElement && !columnElement.id.startsWith('column-')) {
                columnElement = columnElement.parentElement;
            }

            if (columnElement && taskElement) {
                const newStatus = columnElement.id.replace('column-', '');

                // Mueve el elemento en el DOM para una respuesta visual instantánea
                columnElement.appendChild(taskElement);

                // Llama al método de Livewire en el backend para persistir el cambio
                @this.call('updateTaskStatus', taskId, newStatus);
            }
        }
    </script>
    @endpush
</div>