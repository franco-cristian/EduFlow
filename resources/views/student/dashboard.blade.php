@extends('layouts.app')

@section('title', 'Panel del Estudiante')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Bienvenido, {{ auth()->user()->name }}</h1>
        <a href="{{ route('student.projects.create') }}" class="px-4 py-2 bg-education-primary text-white rounded-lg hover:bg-education-secondary transition flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Nuevo Proyecto
        </a>
    </div>

    <!-- Resumen de proyectos -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500">Proyectos Activos</p>
                    <p class="text-2xl font-bold">{{ $activeProjects }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500">Tareas Pendientes</p>
                    <p class="text-2xl font-bold">{{ $pendingTasks }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500">Proyectos Completados</p>
                    <p class="text-2xl font-bold">{{ $completedProjects }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Proyectos recientes -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Mis Proyectos</h2>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($projects as $project)
            <div class="px-6 py-4 hover:bg-gray-50 transition">
                <div class="flex justify-between items-start">
                    <div>
                        <a href="{{ route('student.projects.show', $project) }}" class="text-lg font-medium text-gray-800 hover:text-education-primary">{{ $project->title }}</a>
                        <p class="text-gray-600 mt-1">{{ Str::limit($project->description, 120) }}</p>
                        <div class="flex items-center mt-3">
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $project->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($project->status == 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                            </span>
                            <span class="ml-3 text-sm text-gray-500">
                                {{ $project->start_date->format('d M') }} - {{ $project->end_date->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('student.projects.edit', $project) }}" class="p-2 text-gray-500 hover:text-education-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="px-6 py-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No tienes proyectos aún</h3>
                <p class="mt-1 text-gray-500">Comienza creando tu primer proyecto escolar</p>
                <div class="mt-6">
                    <a href="{{ route('student.projects.create') }}" class="px-4 py-2 bg-education-primary text-white rounded-lg hover:bg-education-secondary transition">
                        Crear proyecto
                    </a>
                </div>
            </div>
            @endforelse
        </div>
        @if($projects->hasPages())
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $projects->links() }}
        </div>
        @endif
    </div>
</div>
@endsection