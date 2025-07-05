@extends('layouts.app')

@section('title', 'Detalle de Tarea')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-md p-6">
        @php
            $task = \App\Models\Task::findOrFail($taskId);
        @endphp
        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $task->title }}</h2>
        <p class="text-gray-600 mb-4">{{ $task->description }}</p>

        <div class="flex items-center justify-between text-sm text-gray-600">
            <span><strong>Estado:</strong> {{ ucfirst(str_replace('_', ' ', $task->status)) }}</span>
            <span><strong>Fecha límite:</strong> {{ $task->due_date->format('d M Y') }}</span>
        </div>

        <div class="mt-4 text-sm text-gray-600">
            <strong>Asignado a:</strong> {{ $task->assignee->name }}
        </div>
    </div>
</div>
@endsection