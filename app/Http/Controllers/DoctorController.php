<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Especialidad;
use App\Models\HorarioDoctor;
use App\Models\paciente;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $doctores = Doctor::all();
            $response = [];

            foreach ($doctores as $item) {
                $doctorData = [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'numeroTel' => $item->numeroTel,
                    'dia' => json_decode($item->dia),
                    'horasAm' => json_decode($item->horaAm),
                    'horasPm' => json_decode($item->horaPm)
                ];

                $response[] = $doctorData;
            }

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $especialidades = Especialidad::all();
        return view('admin.doc', compact('especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        // Valida los datos de la solicitud entrante
        $datosValidados = $request->validate([
            'nombre' => 'required|string|max:45',
            'numeroTel' => 'required|string|max:12',
            'fechaRegistro' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'especialidad_id' => 'required|exists:especialidades,id',
        ]);

        // Crea una nueva instancia de Doctor y la llena con los datos validados
        $doctor = new Doctor([
            'nombre' => $datosValidados['nombre'],
            'numeroTel' => $datosValidados['numeroTel'],
            'fechaRegistro' => $datosValidados['fechaRegistro'],
            'user_id' => $datosValidados['user_id'],
            'especialidad_id' => $datosValidados['especialidad_id'],
        ]);

        $doctor->save();

        // Redirige a una ruta específica o responde con un mensaje de éxito
        return redirect()->route('dash')->with('success', 'Doctor creado exitosamente');
    } catch (\Exception $e) {
        // Registra el error
        dd($e->getMessage());

        // Devuelve una respuesta de error o redirige a una página de error
        return redirect()->back()->with('error', 'Ha ocurrido un error al procesar la solicitud.');
    }
}


    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $doctor = Doctor::findOrfail($id);
            return $doctor;
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
            $doctor = Doctor::findOrfail($id);
            $doctor->nombre = $request->nombre;
            $doctor->numeroTel = $request->numeroTel;
            if ($doctor->update() >= 1) {
                return response()->json(['status' => 'ok', 'data' => $doctor], 202);
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
            $doctor = Doctor::findOrFail($id);
            if ($doctor->delete() >= 1) {
                return response()->json(['status' => 'ok', 'data' => null], 205);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function x()
    {
        $Sas = "Hola";
        session(['idx' => $Sas]);
        return session('idx');
    }
}
