<?php

namespace App\Http\Controllers;

use App\Models\AntecedenteMedico;
use Illuminate\Http\Request;

class AntecedenteMedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hipertencionArterial' => 'required|string|max:2',
            'cardiopatia' => 'required|string|max:2',
            'diabetesMellitu' => 'required|string|max:2',
            'problemaRenal' => 'required|string|max:2',
            'problemaRespiratorio' => 'required|string|max:2',
            'problemaHepatico' => 'required|string|max:2',
            'problemaEndocronico' => 'required|string|max:2',
            'problemaHemorragico' => 'required|string|max:2',
            'alergiaMedicamentos' => 'nullable|string|max:45',
            'embarazo' => 'required|string|max:2',
            'otrosMedicamentosQueToma' => 'required|string|max:100',
            'otrosMedicamentosInfo' => 'nullable|string|max:200',
            'otrosDatos' => 'nullable|string|max:200',
            'paciente_id' => 'required|integer',
        ]);

        // Crear una nueva instancia del modelo Migracion
        $antecedentes = new AntecedenteMedico();
        $antecedentes->hipertencionArterial = $request->input('hipertencionArterial');
        $antecedentes->cardiopatia = $request->input('cardiopatia');
        $antecedentes->diabetesMellitu = $request->input('diabetesMellitu');
        $antecedentes->problemaRenal = $request->input('problemaRenal');
        $antecedentes->problemaRespiratorio = $request->input('problemaRespiratorio');
        $antecedentes->problemaHepatico = $request->input('problemaHepatico');
        $antecedentes->problemaEndocronico = $request->input('problemaEndocronico');
        $antecedentes->problemaHemorragico = $request->input('problemaHemorragico');
        $antecedentes->alergiaMedicamentos = $request->input('alergiaMedicamentos');
        $antecedentes->embarazo = $request->input('embarazo');
        $antecedentes->otrosMedicamentosQueToma = $request->input('otrosMedicamentosQueToma');
        $antecedentes->otrosMedicamentosInfo = $request->input('otrosMedicamentosInfo');
        $antecedentes->otrosDatos = $request->input('otrosDatos');
        $antecedentes->paciente_id = $request->input('paciente_id');
       

        // Guardar el objeto en la base de datos
        $antecedentes->save();
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
