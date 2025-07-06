<?php

// Facades
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controladores
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
// Nota: ProjectController, TaskController, etc., no se están usando aquí todavía. Los añadiremos cuando sea necesario.

// Componentes de Livewire
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;

// Modelos
use App\Models\Project;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas web para tu aplicación.
| Estas rutas son cargadas por RouteServiceProvider y todas
| serán asignadas al grupo de middleware "web".
|
*/

// --- RUTAS DE AUTENTICACIÓN (Públicas y para invitados) ---
Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});

// --- RUTAS PÚBLICAS ---
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome'); // O podrías redirigir a login: return redirect()->route('login');
})->name('welcome');


// --- RUTAS PROTEGIDAS ---
Route::middleware('auth')->group(function () {
    
    // Ruta para cerrar sesión
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    // Dashboard principal que redirige según el rol
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // --- Rutas de ESTUDIANTE ---
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        
        // Rutas que cargan vistas y estas, a su vez, componentes Livewire
        Route::get('/projects', fn() => view('student.projects.index'))->name('projects.index');
        Route::get('/projects/create', fn() => view('student.projects.create'))->name('projects.create');
        Route::get('/projects/{project}', fn(Project $project) => view('student.projects.show', ['project' => $project]))->name('projects.show');
        Route::get('/projects/{project}/edit', fn(Project $project) => view('student.projects.edit', ['project' => $project]))->name('projects.edit');
    });

    // --- Rutas de PROFESOR (para el futuro) ---
    // ...

    // --- Rutas de ADMINISTRADOR ---
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/export-projects', [AdminDashboardController::class, 'exportProjects'])->name('export.projects');
        Route::get('/report-projects', [AdminDashboardController::class, 'generateReport'])->name('report.projects');
    });
    
    // --- Rutas de ACCIÓN COMUNES ---
    Route::get('/files/{file}/download', [FileController::class, 'download'])->name('files.download');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');

    Route::prefix('notifications')->name('notifications.')->group(function() {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('markAllRead');
        Route::get('/{notification}/read', [NotificationController::class, 'markAsRead'])->name('read');
    });
});