<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AntecedenteMedico;

class AntecedenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $antecedentesMedicos = AntecedenteMedico::all();
            $i = 0;
            foreach ($antecedentesMedicos as $a) {
                $response[$i]["paciente"] = $a->paciente->toArray();
                $i++;
            }
            return $antecedentesMedicos;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.antecedentes');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $antecedente = new AntecedenteMedico();
            $antecedente->hipertencionArterial = $request->hipertencionArterial;
            $antecedente->cardiopatia = $request->cardiopatia;
            $antecedente->diabetesMellitu = $request->diabetesMellitu;
            $antecedente->problemaRenal = $request->problemaRenal;
            $antecedente->problemaRespiratorio = $request->problemaRespiratorio;
            $antecedente->problemaHepatico = $request->problemaHepatico;
            $antecedente->problemaEndocronico = $request->problemaEndocronico;
            $antecedente->problemaHemorragico = $request->problemaHemorragico;
            $antecedente->alergiaMedicamentos = $request->alergiaMedicamentos;
            $antecedente->embarazo = $request->embarazo;
            $antecedente->otrosMedicamentosQueToma = $request->otrosMedicamentosQueToma;
            $antecedente->otrosMedicamentosInfo = $request->otrosMedicamentosInfo;
            $antecedente->otrosDatos = $request->otrosDatos;
            $antecedente->paciente_id = $request->paciente_id;
            
            if ($antecedente->save() >= 1) {
                return response()->json(['status' => 'ok', 'data' => $antecedente], 201);
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
