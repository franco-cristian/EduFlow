<div>
    <div class="mb-6 flex justify-between items-center">
        <h3 class="text-2xl font-bold text-gray-800">{{ $project->title }} - Tablero de Tareas</h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Columna TODO -->
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex justify-between items-center mb-4">
                <h4 class="font-semibold text-gray-700">Por Hacer</h4>
                <span class="bg-gray-200 text-gray-700 rounded-full px-3 py-1 text-sm">
                    {{ $todoTasks->count() }}
                </span>
            </div>
            
            <div class="space-y-4" id="todo-column">
                @foreach($todoTasks as $task)
                <div class="bg-white rounded-lg shadow p-4 cursor-move task-card"
                    draggable="true" 
                    wire:key="task-{{ $task->id }}"
                    data-task-id="{{ $task->id }}">
                    <h5 class="font-semibold text-gray-800">{{ $task->title }}</h5>
                    <p class="text-sm text-gray-600 mt-2">{{ $task->description }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-xs text-gray-500">{{ $task->due_date->format('d M Y') }}</span>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded">
                            {{ $task->assignee->name }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Repetir para In Progress y Completed -->
    </div>
    
    @push('scripts')
    <script>
        document.querySelectorAll('.task-card').forEach(card => {
            card.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('task_id', card.dataset.taskId);
            });
        });

        document.querySelectorAll('[id$="-column"]').forEach(column => {
            column.addEventListener('dragover', (e) => {
                e.preventDefault();
            });
            
            column.addEventListener('drop', (e) => {
                e.preventDefault();
                const taskId = e.dataTransfer.getData('task_id');
                const status = column.id.replace('-column', '');
                
                // Actualizar estado via Livewire
                Livewire.dispatch('update-task-status', {
                    taskId: taskId,
                    status: status
                });
            });
        });
    </script>
    @endpush
</div>