@extends('layouts.app')

@section('title', $project->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $project->title }}</h1>
            <div class="flex items-center mt-2 space-x-4">
                {{-- Aquí puedes añadir un componente Blade para el estado --}}
                <span class="text-sm text-gray-500">
                    {{ $project->start_date->format('d M Y') }} - {{ $project->end_date->format('d M Y') }}
                </span>
            </div>
        </div>
        @can('update', $project)
            <a href="{{ route('student.projects.edit', $project) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                Editar
            </a>
        @endcan
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Columna principal -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Descripción del Proyecto -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Descripción</h2>
                <div class="prose max-w-none text-gray-600">
                    {!! nl2br(e($project->description)) !!}
                </div>
            </div>
            
            <!-- Tablero Kanban -->
            @livewire('projects.kanban-board', ['project' => $project])

        </div>
        
        <!-- Columna lateral -->
        <div class="space-y-8">
            <!-- Progreso -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Progreso</h2>
                <p class="text-3xl font-bold">{{ $project->progress }}%</p>
                <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                    <div class="bg-education-primary h-2.5 rounded-full" style="width: {{ $project->progress }}%"></div>
                </div>
            </div>
            
            <!-- Archivos -->
            @livewire('ui.file-uploader', ['projectId' => $project->id])
            
            <!-- Feedback -->
            @livewire('ui.feedback-component', ['projectId' => $project->id])
        </div>
    </div>
</div>
@endsection