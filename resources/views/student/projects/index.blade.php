@extends('layouts.app')

@section('title', 'Mis Proyectos')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{-- El componente Livewire manejará toda la lógica y la visualización --}}
    {{-- Crearemos este componente en un paso posterior --}}
    @livewire('projects.project-list')
</div>
@endsection