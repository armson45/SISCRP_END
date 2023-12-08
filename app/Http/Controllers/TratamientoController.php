<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tratamiento;

class TratamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tratamientos = Tratamiento::all();
            $response = $tratamientos->toArray();
            $i = 0;
            foreach ($tratamientos as $tratamiento) {
                $response[$i]["especialidad"] = $tratamiento->especialidad->toArray();
                $i++;                                        
            }
            return $response;/*  view('tratamiento', ['tratamientoes' => $tratamientoes]) */
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tratamientos');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $tratamiento = new Tratamiento();
            $tratamiento->nombreTrabajo = $request->nombreTrabajo;
            $tratamiento->descripcion = $request->descripcion;
            $tratamiento->imagen = $request->imagen;
            $tratamiento->precio = $request->precio;
            $tratamiento->fechaInicio = $request->fechaInicio;
            $tratamiento->fechaFinal = $request->fechaFinal;
            $tratamiento->especialidad_id = $request->especialidad_id;
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('img/prevista/'), $nombreImagen);
                $tratamiento->imagen = $nombreImagen;
            }
            if ($tratamiento->save() >= 1) {
                return response()->json(['status' => 'ok', 'data' => $tratamiento], 201);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $tratamiento = Tratamiento::findOrfail($id);
            return $tratamiento;
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
            $tratamiento = Tratamiento::findOrfail($id);
            $tratamiento->nombreTrabajo = $request->nombreTrabajo;
            $tratamiento->descripcion = $request->descripcion;
            $tratamiento->imagen = $request->imagen;
            $tratamiento->precio = $request->precio;
            $tratamiento->fechaInicio = $request->fechaInicio;
            $tratamiento->fechaFinal = $request->fechaFinal;
            $tratamiento->especialidad_id = $request->especialidad_id;
            $imagenAnterior = $tratamiento->imagen;

            if ($request->hasFile('imagen')) {
                $imagePath = public_path() . '/img/prevista/' . $imagenAnterior;
                if ($imagenAnterior != 'none.jpg' && $imagenAnterior != $tratamiento->imagen) {
                    unlink($imagePath);
                }
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $imagen->move(public_path('img/prevista/'), $nombreImagen);
                $tratamiento->imagen = $nombreImagen;
            } else {
                if ($imagenAnterior != $tratamiento->imagen) {
                    $tratamiento->imagen = "none.jpg";
                }
            }
            if ($tratamiento->update() >= 1) {
                return response()->json(['status' => 'ok', 'data' => $tratamiento], 202);
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
        try{
            $tratamiento=Tratamiento::findOrFail($id);
            $imagenAnterior= $tratamiento->imagen;
            $imagePath = public_path() . '/img/prevista/'. $imagenAnterior;
            if($imagenAnterior != 'none.jpg'){
             unlink($imagePath);
            }
            if($tratamiento->delete()>=1){
             return response()->json(['status'=>'ok','data'=>null],205);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function publicidad()
    {
        try {
            $tratamientoes = Tratamiento::where('fechaInicio', '>', 0)->get();


            return view('tratamiento', ['tratamientoes' => $tratamientoes]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function tratamiento()
    {
        try {
            $tratamientos = Tratamiento::whereNull('fechaInicio')->get();
            return view('tratamiento', ['tratamientos' => $tratamientos]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    } 
    public function trata()
    {
        try {
            $tratamientos = Tratamiento::whereNull('fechaInicio')->get();
            return view('cita', ['tratamientos' => $tratamientos]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    } 
}
