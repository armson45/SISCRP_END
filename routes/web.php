<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PublicidadController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\TratamientoController;
use App\Http\Controllers\TrabajoController;
use App\Http\Controllers\AntecedenteController;
use App\Models\AntecedenteMedico;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AntecedenteMedicoController;
use App\Http\Controllers\EspecialidadesController;
use App\Http\Controllers\RadiogrfiaController;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Tratamiento;
use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return Redirect::to('/welcome');
});




Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/cita', function () {
    return view('cita');
});



Route::get('/antecedentes', function () {
    return view('antecedentes');
});

Route::get('/publicaciones', function () {
    return view('publicidad');
});

Route::get('/tratamiens', function () {
    return view('tratamiento');
});





Auth::routes();

$usuario = Auth::user();
Route::get('/admin', [HomeController::class, 'dash'])->name('dash')->middleware('checkType:1');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/pacientes', PacienteController::class)->middleware('auth');
Route::resource('/radios', RadiogrfiaController::class)->middleware('auth');
Route::resource('/doctores', DoctorController::class)->middleware('auth');
//Route::Resource('/aver',PublicidadController::class); ruta desfasada anteriori publicidad que se cambio a tratamientos
Route::resource('/citas', CitaController::class)->middleware('auth');
Route::resource('/tratamient', TratamientoController::class)->middleware('auth');
Route::post('/tratamient/{tratamiento}', [TratamientoController::class, 'update'])->middleware('auth');
Route::resource('/trabajos', TrabajoController::class)->middleware('auth');
Route::resource('/citas-vista', CitaController::class)->middleware('auth');
Route::resource('/antece', AntecedenteController::class)->middleware('auth');
Route::resource('/especialidades', EspecialidadesController::class)->middleware('auth');



//rutas para el lado del cliente
Route::post('/antecedentes', [AntecedenteMedicoController::class, 'store'])->name('antecedentes.store')->middleware('auth');
Route::get('/publicaciones', [TratamientoController::class, 'publicidad'])->name('publicaciones');
Route::get('/tratamientos', [TratamientoController::class, 'tratamiento'])->name('tratamiens');

Route::get('/cita', [CitaController::class, 'showCita'])->name('cita')->middleware('auth')->middleware('auth');
Route::get('/tratamiento', [TratamientoController::class, 'tratamiento'])->name('tratamiento.show')->middleware('auth');
Route::post('/citas', [CitaController::class, 'storeCita'])->name('citasCliente.store')->middleware('auth');
Route::post('/guardar-paciente', [PacienteController::class, 'storePaciente'])->name('guardar-paciente')->middleware('auth');
Route::get('/crear-paciente', [PacienteController::class, 'crearPaciente'])->name('crear-paciente')->middleware('auth');
Route::get('/verificar-paciente', [PacienteController::class, 'verificarPaciente'])->name('verificar-paciente');
Route::get('/obtener-paciente', [CitaController::class, 'obtenerPaciente'])->name('obtenerPaciente');





Route::post('/mostrar-citas', [CitaController::class, 'mostrarCitasPorEspecialidad'])->name('mostrar-citas');
Route::get('/mostrar-citas', [CitaController::class, 'mostrarCitasPorEspecialidad']);

Route::get('/obtener-horas-disponibles', [CitaController::class, 'obtenerHorasDisponibles'])
    ->name('obtener-horas-disponibles');
