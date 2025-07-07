@extends('layouts.app')
@section('title', 'Mis Proyectos')
@section('content')
    {{-- La llamada debe coincidir con la ubicación del componente --}}
    @livewire('student.project-list')
@endsection