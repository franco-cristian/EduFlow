@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-md p-8 max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Mi Perfil</h1>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-500">Nombre</label>
                <p class="text-lg text-gray-800">{{ auth()->user()->name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500">Correo Electrónico</label>
                <p class="text-lg text-gray-800">{{ auth()->user()->email }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500">Rol</label>
                <p class="text-lg text-gray-800 capitalize">{{ auth()->user()->role }}</p>
            </div>
             <div>
                <label class="block text-sm font-medium text-gray-500">Miembro desde</label>
                <p class="text-lg text-gray-800">{{ auth()->user()->created_at->translatedFormat('d F Y') }}</p>
            </div>
        </div>
        
        <div class="mt-8 border-t pt-6">
            <p class="text-gray-600">Esta sección se ampliará para permitir la edición de datos y cambio de contraseña.</p>
        </div>
    </div>
</div>
@endsection