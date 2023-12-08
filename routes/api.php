<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\TrabajoController;
use App\Http\Controllers\TratamientoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('/trabajos',TrabajoController::class);
Route::resource('/citas',CitaController::class);
Route::resource('/pacientes',PacienteController::class);
Route::resource('doctores',DoctorController::class);
//Route::Resource('/aver',PublicidadController::class); ruta desfasada anteriori publicidad que se cambio a tratamientos
Route::resource('/tratamient', TratamientoController::class);
Route::resource('/antece', AntecedenteController::class);
