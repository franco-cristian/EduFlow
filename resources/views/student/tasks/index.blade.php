@extends('layouts.app')

@section('title', 'Tareas del Proyecto')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Tareas asignadas</h2>
        <a href="{{ route('student.tasks.create', $projectId) }}" class="px-4 py-2 bg-education-primary text-white rounded-lg hover:bg-education-secondary flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Nueva Tarea
        </a>
    </div>

    <livewire:kanban-board :project="$projectId" />
</div>
@endsection