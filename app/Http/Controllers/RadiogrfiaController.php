<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Radiografia;
use Illuminate\Http\Request;

class RadiogrfiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $radioGrafias = Radiografia::all();
            return $radioGrafias;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.radioGrafias');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $radio = new Radiografia();
            $radio->nombre=$request->nombre;
            $radio->fecha = now();
            $radio->paciente_id = $request->paciente_id;
            if($request->hasFile('nombre')){
                $nombre = $request->file('nombre');
                $nombreImagen = time() . '_' . $nombre -> getClientOriginalName();
                $nombre->move(public_path('img/prevista/'),$nombreImagen);
                $radio->nombre = $nombreImagen;
            }
            else{
                $radio->nombre = "none.jpg";
            }

            if($radio->save()>=1){
             return response()->json(['status'=>'ok','data'=>$radio],201);
            }
         }catch(\Exception $e){
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
        try{
            $tratamiento=Radiografia::findOrFail($id);
            $imagenAnterior= $tratamiento->nombre;
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
}
