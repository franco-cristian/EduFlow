<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Project;

// Todas las rutas aquí dentro requerirán un token de autenticación válido
// gracias al middleware 'auth:sanctum' que Laravel aplica por defecto a este archivo.
Route::middleware('auth:sanctum')->group(function () {

    // Endpoint 1: Devolver el usuario autenticado. Muy útil para saber "quién soy".
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Endpoint 2: Listar todos los proyectos del usuario autenticado.
    Route::get('/projects', function (Request $request) {
        // Obtenemos el usuario autenticado a través del token.
        $user = $request->user();
        
        // Cargamos sus proyectos. El método ->get() los traerá.
        $projects = $user->projects()->get();
        
        // Laravel convertirá automáticamente esta colección a JSON.
        return $projects;
    });

    // Endpoint 3: Obtener detalles de un proyecto específico.
    Route::get('/projects/{project}', function (Request $request, Project $project) {
        // Verificamos con la Policy que el usuario autenticado puede ver este proyecto.
        if ($request->user()->cannot('view', $project)) {
            return response()->json(['error' => 'No autorizado'], 403);
        }
        
        // Cargamos las relaciones para una respuesta más completa y devolvemos el JSON.
        return $project->load(['tasks', 'files', 'feedbacks.user', 'teacher']);
    });

});