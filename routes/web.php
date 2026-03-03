<?php

use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\consulta;
use App\Models\paciente;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'pacientes' => paciente::count(),
        'consultas' => consulta::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/about', fn () => Inertia::render('About'))->name('about');

    Route::get('pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
    Route::post('pacientes', [PacienteController::class, 'store'])->name('pacientes.store');
    Route::patch('pacientes/{id}', [PacienteController::class, 'update'])->name('pacientes.update');
    Route::delete('pacientes/{id}', [PacienteController::class, 'destroy'])->name('pacientes.destroy');

    Route::get('pacientes/{id}', [ExpedienteController::class, 'edit'])->name('expedientes.edit');
    Route::patch('expedientes/{id}', [ExpedienteController::class, 'updateexpediente'])->name('expedientes.update');
    Route::post('consultas', [ExpedienteController::class, 'storeconsulta'])->name('consultas.store');
    Route::patch('consultas/{id}', [ExpedienteController::class, 'updateconsulta'])->name('consultas.update');
    Route::delete('consultas/{id}', [ExpedienteController::class, 'destroyconsulta'])->name('consultas.destroy');

    Route::get('consultas', [ConsultaController::class, 'index'])->name('consultas.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
