@extends('layouts.app')

@section('title', 'Nueva Tarea')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Crear nueva tarea</h2>
    <livewire:task-form :project-id="$projectId" />
</div>
@endsection