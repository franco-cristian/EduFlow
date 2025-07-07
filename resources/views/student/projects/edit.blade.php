@extends('layouts.app')

@section('title', 'Editar Proyecto')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Proyecto: {{ $project->title }}</h1>
    
    <div class="max-w-4xl mx-auto">
        @livewire('student.project-form', ['projectId' => $project->id])
    </div>
</div>
@endsection