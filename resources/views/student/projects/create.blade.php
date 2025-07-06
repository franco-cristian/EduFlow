@extends('layouts.app')

@section('title', 'Crear Nuevo Proyecto')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Crear Nuevo Proyecto</h1>
    
    <div class="max-w-4xl mx-auto">
        @livewire('projects.project-form')
    </div>
</div>
@endsection