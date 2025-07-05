@extends('layouts.app')

@section('title', $project->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $project->title }}</h1>
            <div class="flex items-center mt-2">
                <span class="px-3 py-1 text-xs rounded-full 
                    {{ $project->status == 'completed' ? 'bg-green-100 text-green-800' : 
                       ($project->status == 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                </span>
                <span class="ml-3 text-sm text-gray-500">
                    {{ $project->start_date->format('d M Y') }} - {{ $project->end_date->format('d M Y') }}
                </span>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('student.projects.edit', $project) }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Editar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Información principal -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Descripción del Proyecto</h2>
                <div class="prose max-w-none">
                    {!! nl2br(e($project->description)) !!}
                </div>
            </div>

            <!-- Tablero Kanban -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-800">Tareas del Proyecto</h2>
                    <button class="px-4 py-2 bg-education-primary text-white rounded-lg hover:bg-education-secondary flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Nueva Tarea
                    </button>
                </div>
                <livewire:kanban-board :project="$project" />
            </div>
        </div>

        <!-- Panel lateral -->
        <div>
            <!-- Progreso -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Progreso del Proyecto</h2>
                <div class="mb-4">
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Completado</span>
                        <span class="text-sm font-medium text-gray-700">{{ $progress }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-education-primary h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-4 text-center mt-6">
                    <div>
                        <div class="text-2xl font-bold text-gray-800">{{ $todoTasks }}</div>
                        <div class="text-sm text-gray-600">Por hacer</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-800">{{ $inProgressTasks }}</div>
                        <div class="text-sm text-gray-600">En progreso</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-800">{{ $completedTasks }}</div>
                        <div class="text-sm text-gray-600">Completadas</div>
                    </div>
                </div>
            </div>

            <!-- Retroalimentación -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Retroalimentación</h2>
                @if($feedbacks->count() > 0)
                <div class="space-y-4">
                    @foreach($feedbacks as $feedback)
                    <div class="border-l-4 border-education-primary pl-4 py-2">
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                <span class="font-semibold text-gray-700">{{ strtoupper(substr($feedback->user->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">{{ $feedback->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $feedback->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <p class="text-gray-700">{{ $feedback->content }}</p>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <p class="mt-4 text-gray-500">Aún no hay retroalimentación</p>
                </div>
                @endif
                
                <form class="mt-6">
                    <textarea rows="3" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-1 focus:ring-education-primary" placeholder="Agrega tus comentarios..."></textarea>
                    <button type="submit" class="mt-3 px-4 py-2 bg-education-primary text-white rounded-lg hover:bg-education-secondary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection