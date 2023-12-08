<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Especialidad;
use Illuminate\Http\Request;

class EspecialidadesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $marcas =Especialidad::all();
            return $marcas;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.especialidades');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $marca = new Especialidad();
            $marca->nombre=$request->nombre;
            if($marca->save()>=1){
             return response()->json(['status'=>'ok','data'=>$marca],201);
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
        try{
            $marca=Especialidad::findOrfail($id);
              $marca->nombre=$request->nombre;
            if($marca->update()>=1){
             return response()->json(['status'=>'ok','data'=>$marca],202);
            }
         }catch(\Exception $e){
             return $e->getMessage();
         }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $marca=Especialidad::findOrFail($id);
            if($marca->delete()>=1){
             return response()->json(['status'=>'ok','data'=>null],205);
            }
         }catch(\Exception $e){
             return $e->getMessage();
         }
    }
}
