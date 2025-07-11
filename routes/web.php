<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FileController;

// Livewire Components
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\ManageUsers;
use App\Livewire\Admin\ProjectList as AdminProjectList;
use App\Livewire\Student\Dashboard as StudentDashboard;
use App\Livewire\Student\ProjectList;
use App\Livewire\Student\ProjectForm;
use App\Livewire\Student\ShowProject;
use App\Livewire\Teacher\Dashboard as TeacherDashboard;
use App\Livewire\Profile\Show as ProfileShow;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTA RAÍZ ---
Route::get('/', function () {
    return redirect(Auth::check() ? route('dashboard') : route('login'));
})->name('welcome');

// --- RUTAS DE AUTENTICACIÓN ---
Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});

// --- RUTAS PROTEGIDAS ---
Route::middleware('auth')->group(function () {

    // RUTA DASHBOARD CENTRAL
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->isTeacher()) {
            return redirect()->route('teacher.dashboard');
        }
        return redirect()->route('student.dashboard');
    })->name('dashboard');

    // RUTAS DE UTILIDAD
    Route::post('/logout', function () { Auth::logout(); request()->session()->invalidate(); request()->session()->regenerateToken(); return redirect('/'); })->name('logout');
    Route::get('/profile', ProfileShow::class)->name('profile.show');

    // --- RUTAS DE ESTUDIANTE ---
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', StudentDashboard::class)->name('dashboard');
        Route::get('/projects', ProjectList::class)->name('projects.index');
        Route::get('/projects/create', ProjectForm::class)->name('projects.create');
        Route::get('/projects/{project}/edit', ProjectForm::class)->name('projects.edit');
    });

    // --- RUTA COMPARTIDA ---
    Route::get('/projects/{project}', ShowProject::class)->name('projects.show');

    // --- RUTAS DE PROFESOR ---
    Route::middleware('role:teacher')->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', TeacherDashboard::class)->name('dashboard');
    });

    // --- RUTAS DE ADMINISTRADOR ---
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
        Route::get('/users', ManageUsers::class)->name('users.index');
        Route::get('/projects', AdminProjectList::class)->name('projects.index');
    });

    // --- RUTAS COMUNES ---
    Route::get('/files/{file}/download', [FileController::class, 'download'])->name('files.download');
});