<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Student\ShowProject;
use App\Models\Project;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTAS DE AUTENTICACIÓN (Públicas y para invitados) ---
Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});

// --- RUTA PRINCIPAL ---
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    // CORRECCIÓN: Redirigir siempre al login si no está autenticado.
    return redirect()->route('login');
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

    // --- RUTAS DE PERFIL Y PÁGINAS ESTÁTICAS ---
    Route::get('/profile', function () {
        // En el futuro, esto será un componente Livewire completo.
        return view('profile.show');
    })->name('profile.show');

    // --- Rutas de ESTUDIANTE ---
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

        // Rutas que cargan vistas y estas, a su vez, componentes Livewire
        Route::get('/projects', fn() => view('student.projects.index'))->name('projects.index');
        Route::get('/projects/create', fn() => view('student.projects.create'))->name('projects.create');
        Route::get('/projects/{project}', ShowProject::class)->name('projects.show');
        Route::get('/projects/{project}/edit', fn(Project $project) => view('student.projects.edit', ['project' => $project]))->name('projects.edit');
    });

    // --- Rutas de ADMINISTRADOR ---
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // CORRECCIÓN: La ruta de proyectos de admin aún no existe, vamos a crear una placeholder.
        Route::get('/projects', fn() => view('admin.projects.index'))->name('projects.index');

        Route::get('/export-projects', [AdminDashboardController::class, 'exportProjects'])->name('export.projects');
        Route::get('/report-projects', [AdminDashboardController::class, 'generateReport'])->name('report.projects');
    });

    // --- Rutas de ACCIÓN COMUNES ---
    Route::get('/files/{file}/download', [FileController::class, 'download'])->name('files.download');
    Route::delete('/files/{file}', [FileController::class, 'destroy'])->name('files.destroy');

    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('markAllRead');
        Route::get('/{notification}/read', [NotificationController::class, 'markAsRead'])->name('read');
    });
});
