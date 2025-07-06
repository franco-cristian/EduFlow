<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Columna POR HACER -->
    <div id="todo" class="bg-gray-100 rounded-lg p-4" 
         ondrop="drop(event)" ondragover="allowDrop(event)">
        <div class="flex justify-between items-center mb-4">
            <h4 class="font-semibold text-gray-700">Por Hacer</h4>
            <span class="bg-gray-200 text-gray-700 rounded-full px-3 py-1 text-sm">
                {{ $todoTasks->count() }}
            </span>
        </div>
        <div class="space-y-4 min-h-[200px]">
            @forelse($todoTasks as $task)
                <div id="task-{{ $task->id }}" class="bg-white rounded-lg shadow p-4 cursor-move" draggable="true" ondragstart="drag(event)">
                    <h5 class="font-semibold text-gray-800">{{ $task->title }}</h5>
                    <p class="text-sm text-gray-600 mt-2">{{ Str::limit($task->description, 80) }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</span>
                        @if($task->assignee)
                            <x-badge color="blue">{{ $task->assignee->name }}</x-badge>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 pt-10">No hay tareas.</div>
            @endforelse
        </div>
    </div>

    <!-- Columna EN PROGRESO -->
    <div id="in_progress" class="bg-gray-100 rounded-lg p-4"
         ondrop="drop(event)" ondragover="allowDrop(event)">
        <div class="flex justify-between items-center mb-4">
            <h4 class="font-semibold text-yellow-700">En Progreso</h4>
            <span class="bg-yellow-200 text-yellow-700 rounded-full px-3 py-1 text-sm">
                {{ $inProgressTasks->count() }}
            </span>
        </div>
        <div class="space-y-4 min-h-[200px]">
             @forelse($inProgressTasks as $task)
                <div id="task-{{ $task->id }}" class="bg-white rounded-lg shadow p-4 cursor-move" draggable="true" ondragstart="drag(event)">
                    <h5 class="font-semibold text-gray-800">{{ $task->title }}</h5>
                    <p class="text-sm text-gray-600 mt-2">{{ Str::limit($task->description, 80) }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</span>
                        @if($task->assignee)
                            <x-badge color="yellow">{{ $task->assignee->name }}</x-badge>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 pt-10">Arrastra una tarea aquí.</div>
            @endforelse
        </div>
    </div>

    <!-- Columna COMPLETADO -->
    <div id="completed" class="bg-gray-100 rounded-lg p-4"
         ondrop="drop(event)" ondragover="allowDrop(event)">
        <div class="flex justify-between items-center mb-4">
            <h4 class="font-semibold text-green-700">Completado</h4>
            <span class="bg-green-200 text-green-700 rounded-full px-3 py-1 text-sm">
                {{ $completedTasks->count() }}
            </span>
        </div>
        <div class="space-y-4 min-h-[200px]">
             @forelse($completedTasks as $task)
                <div id="task-{{ $task->id }}" class="bg-white rounded-lg shadow p-4 cursor-move" draggable="true" ondragstart="drag(event)">
                    <h5 class="font-semibold text-gray-800 line-through">{{ $task->title }}</h5>
                    <p class="text-sm text-gray-600 mt-2">{{ Str::limit($task->description, 80) }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}</span>
                         @if($task->assignee)
                            <x-badge color="green">{{ $task->assignee->name }}</x-badge>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 pt-10">Arrastra una tarea aquí.</div>
            @endforelse
        </div>
    </div>

    @push('scripts')
    <script>
        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        function drop(ev) {
            ev.preventDefault();
            const taskId = ev.dataTransfer.getData("text").replace('task-', '');
            let columnEl = ev.target;
            while(!columnEl.id) {
                columnEl = columnEl.parentElement;
            }
            const status = columnEl.id;
            
            // Usamos Livewire.dispatch, que es la forma correcta en v3
            Livewire.dispatch('task-updated', { taskId: taskId, status: status });
        }
    </script>
    @endpush
</div>