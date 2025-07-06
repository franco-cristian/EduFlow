@extends('layouts.app')

@section('title', 'Panel del Estudiante')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Bienvenido, {{ auth()->user()->name }}</h1>
        <a href="{{ route('student.projects.create') }}" class="inline-flex items-center px-4 py-2 bg-education-primary text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-education-secondary transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Nuevo Proyecto
        </a>
    </div>

    <!-- Resumen de tarjetas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <x-card class="flex items-center p-6">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Proyectos Activos</p>
                <p class="text-2xl font-bold text-gray-900">{{ $activeProjects }}</p>
            </div>
        </x-card>
        <x-card class="flex items-center p-6">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Tareas Pendientes</p>
                <p class="text-2xl font-bold text-gray-900">{{ $pendingTasks }}</p>
            </div>
        </x-card>
        <x-card class="flex items-center p-6">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Proyectos Completados</p>
                <p class="text-2xl font-bold text-gray-900">{{ $completedProjects }}</p>
            </div>
        </x-card>
    </div>

    <!-- Proyectos recientes -->
    <x-card>
        <x-slot name="header">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Mis Proyectos Recientes</h3>
                <a href="{{ route('student.projects.index') }}" class="text-sm font-medium text-education-primary hover:text-education-secondary">Ver todos</a>
            </div>
        </x-slot>
        
        <div class="divide-y divide-gray-200">
            @forelse($projects as $project)
                <div class="p-4 flex justify-between items-center hover:bg-gray-50">
                    <div>
                        <a href="{{ route('student.projects.show', $project) }}" class="font-semibold text-gray-800">{{ $project->title }}</a>
                        <p class="text-sm text-gray-500 mt-1">Fecha de entrega: {{ $project->end_date->format('d M, Y') }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <x-badge :color="$project->status === 'completed' ? 'green' : ($project->status === 'in_progress' ? 'yellow' : 'blue')">
                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                        </x-badge>
                        <div class="w-24">
                            <p class="text-sm text-gray-600 text-right">{{ $project->progress() }}%</p>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                <div class="bg-education-primary h-1.5 rounded-full" style="width: {{ $project->progress() }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-500">
                    <p>Aún no has creado ningún proyecto.</p>
                    <a href="{{ route('student.projects.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-education-primary text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-education-secondary transition">
                        Crea tu primer proyecto
                    </a>
                </div>
            @endforelse
        </div>
        
        @if($projects->hasPages())
        <x-slot name="footer">
            {{ $projects->links() }}
        </x-slot>
        @endif
    </x-card>

</div>
@endsection