<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Trabajo;
use App\Models\HistorialTrabajo;

class TrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $trabajos = Trabajo::all();
            $response = $trabajos->toArray();
            $i=0;
            foreach($trabajos as $trabajo){
                $response[$i]['doctor']=$trabajo->doctor->toArray();
                $historial =$trabajo->historial_trabajos->toArray();
                $f=0;
                foreach($trabajo->historial_trabajos as $d){
                    $historial[$f]['cita']=$d->cita->toArray();
                    $historial[$f]['cita']['paciente']=$d->cita->paciente->toArray();
                    $historial[$f]['cita']['tratamiento']=$d->cita->tratamiento->toArray();
                    $f++;               
                } 
                $response[$i]['historialTrabajo']=$historial;
                $i++;
            }
            return $response;
            //return $trabajos;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.trabajos');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $errores = 0;
            DB::beginTransaction();

            $trabajo = new Trabajo();
            $trabajo->nombre = $request->nombre;
            $trabajo->estado = $request->estado;
            $trabajo->fecha = now();
            $trabajo->observacion = $request->observacion;
            $trabajo->costo = $request->costo;
            $trabajo->saldo = $request->saldo;
            $trabajo->abono = $request->abono;
            $trabajo->doctor_id = $request->doctor['id'];
            if ($trabajo->save() <= 0) {
                $errores++;
            }
            $historial = $request->historialTrabajo;
            foreach ($historial as $key => $det) {
                $historialTrabajo = new HistorialTrabajo();
                $historialTrabajo->fecha = now();
                $historialTrabajo->cita_id = $det['cita']['id'];
                $historialTrabajo->trabajo_id = $trabajo->id;
                if ($historialTrabajo->save() <= 0) {
                    $errores++;
                }
                if ($errores == 0) {
                    DB::commit();
                    return response()->json(['status' => 'ok', 'data' => $trabajo], 201);
                } else {
                    DB::rollBack();
                    return response()->json(['status' => 'ok', 'data' => $trabajo], 202);
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
