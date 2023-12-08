<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Especialidad;
use App\Models\HorarioDoctor;
use App\Models\Paciente;
use App\Models\Publicidad;
use App\Models\Tratamiento;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $citas = Cita::all();
            $i = 0;
            foreach ($citas as $a) {
                $response[$i]["paciente"] = $a->paciente->toArray();
                $response[$i]["tratamiento"] = $a->tratamiento->toArray();
                $i++;
            }
            return $citas;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.citas');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $cita = new Cita();
            $cita->dia = $request->dia;
            $cita->hora = $request->hora;
            $cita->paciente_id = $request->paciente_id;
            $cita->doctor_id = $request->doctor_id;
            $cita->tratamiento_id = $request->tratamiento_id;
            if ($cita->save() >= 1) {
                return response()->json(['status' => 'ok', 'data' => $cita], 201);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Paciente $paciente)
    {
        try {
            $citas = Cita::where('paciente_id', '=', $paciente->correlativo)->get();
            $response = $citas->toArray();
            $i = 0;
            foreach ($citas as $cita) {
                $response[$i]['paciente'] = $cita->paciente->toArray();
                $response[$i]['paciente']['user'] = $cita->paciente->user->toArray();
                $response[$i]['tratamiento'] = $cita->tratamiento->toArray();
                $historial = $cita->historial_trabajo->toArray();
                $f = 0;
                foreach ($cita->historial_trabajo as $d) {
                    $historial[$f]['trabajo'] = $d->trabajo->toArray();
                    $historial[$f]['trabajo']['doctor'] = $d->trabajo->doctor->toArray();
                    $f++;
                }
                $response[$i]['historialTrabajo'] = $historial;
                $i++;
            }
            return $response;
            //return $citas;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $cita = Cita::findOrfail($id);
            $cita->dia = $request->dia;
            $cita->hora = $request->hora;
            $cita->paciente_id = $request->paciente['id'];
            $cita->doctor_id = $request->doctor['id'];
            $cita->tratamiento_id = $request->tratamiento['id'];
            if ($cita->update() >= 1) {
                return response()->json(['status' => 'ok', 'data' => $cita], 202);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $cita = Cita::findOrFail($id);
            if ($cita->delete() >= 1) {
                return response()->json(['status' => 'ok', 'data' => null], 205);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }




    public function showPaciente()
    {
        $user = Auth::user();
        $paciente = Paciente::where('user_id', $user->id)->first();
        return $paciente;
    }

    public function showTratamiento()
    {
        try {

            $especialidades = Especialidad::all();
            return $especialidades;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public static function paciente()
    {
        try {
            $user = Auth::user();
            $paciente = Paciente::where('user_id', $user->id)->first();
            return $paciente;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function showCita()
    {
        $pacientes = $this->showPaciente();
        $especialidades = $this->showTratamiento();


        return view('cita', [
            'pacientes' => $pacientes,
            'especialidades' => $especialidades,

        ]);
    }
    public function storeCita(Request $request)
    {

        Log::info('Solicitud recibida para almacenar cita', $request->all());
    

        try {
            Log::info('Intentando almacenar cita...');
            $cita = new Cita;
            $cita->dia = $request->dia;
            $cita->hora = $request->hora;
            $cita->paciente_id = $request->paciente_id;
            $cita->especialidad_id = $request->especialidad_id;
            $cita->save();
            Log::info('Cita almacenada exitosamente.');

            return view('welcome')->with('success', 'Cita agendada exitosamente');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error al procesar la solicitud.');
        }
    }


    public function mostrarCitasPorEspecialidad(Request $request)
    {
        try {
            $especialidadId = $request->input('especialidad_id');
            $citas = (new Cita())->getCitasDelMesPorEspecialidad($especialidadId);
            $eventos = [];

            foreach ($citas as $cita) {
                $eventos[] = [
                    'title' => $cita->id,
                    'start' => $cita->dia . 'T' . $cita->hora,
                ];
            }
            $especialidades = Especialidad::all();
            // Generar horas disponibles para el día actual

            return view('cita', compact('eventos', 'especialidades',));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error al procesar la solicitud.');
        }
    }

    public function obtenerHorasDisponibles(Request $request)
    {
        try {
            $fechaSeleccionada = $request->input('fechaSeleccionada');

            // Obtener todas las horas disponibles
            $horasDisponibles = $this->generarHorasDisponibles();

            // Obtener las horas ocupadas en la fecha seleccionada
            $horasOcupadas = $this->obtenerHorasOcupadas($fechaSeleccionada);

            // Filtrar las horas disponibles eliminando las ocupadas
            $horasDisponibles = array_diff($horasDisponibles, $horasOcupadas);

            return response()->json(['horasDisponibles' => array_values($horasDisponibles)]);
        } catch (\Exception $e) {
            // Imprime el error en el controlador
            $errorMessage = 'Error al obtener las horas disponibles: ' . $e->getMessage();

            return response()->json(['error' => $errorMessage], 500);
        }
    }




    private function generarHorasDisponibles()
    {
        $horasDisponibles = [];
        $horaInicio = strtotime('08:00');
        $horaFin = strtotime('12:00');

        while ($horaInicio < $horaFin) {
            $horasDisponibles[] = date('H:i', $horaInicio);
            $horaInicio = strtotime('+30 minutes', $horaInicio);
        }

        return $horasDisponibles;
    }
    // Método para obtener las horas ocupadas desde la base de datos
    private function obtenerHorasOcupadas($fecha)
    {
        $horasOcupadas = DB::table('citas')
            ->whereDate('dia', $fecha)
            ->whereNotNull('hora')
            ->pluck('hora')
            ->toArray();

        // Eliminar espacios y formatear las horas
        $horasOcupadas = array_map('trim', $horasOcupadas);
        $horasOcupadas = array_map(function ($hora) {
            return date('H:i', strtotime($hora));
        }, $horasOcupadas);

        return $horasOcupadas;
    }
}
