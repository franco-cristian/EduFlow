@extends('layouts.app')

@section('title', 'Editar Tarea')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Editar tarea</h2>
    <livewire:task-form :project-id="null" :task-id="$taskId" />
</div>
@endsection