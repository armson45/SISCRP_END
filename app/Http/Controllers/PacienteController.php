<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\paciente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $pacientes = Paciente::all();
            return $pacientes;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pacientes');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $paciente = new Paciente();
            $paciente->codigo = $this->getCodigo();
            $paciente->nombreCom = $request->nombreCom;
            $paciente->fechaNacimiento = $request->fechaNacimiento;
            $paciente->numTel = $request->numTel;
            $paciente->fechaRegistro = now();
            $paciente->user_id = $request->user['id'];
            if ($paciente->save() >= 1) {
                return response()->json(['status' => 'ok', 'data' => $paciente], 201);
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
            $paciente = Paciente::findOrfail($id);
            return $paciente;
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
            $paciente = Paciente::findOrfail($id);
            $paciente->nombreCom = $request->nombreCom;
            $paciente->fechaNacimiento = $request->fechaNacimiento;
            $paciente->numTel = $request->numTel;
            if ($paciente->update() >= 1) {
                return response()->json(['status' => 'ok', 'data' => $paciente], 202);
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
            $paciente = Paciente::findOrFail($id);
            if ($paciente->delete() >= 1) {
                return response()->json(['status' => 'ok', 'data' => null], 205);
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    private function getCodigo()
    {
        $result = DB::select("SELECT CONCAT(TRIM(YEAR(CURDATE())),LPAD(TRIM(MONTH(CURDATE())),2,0),LPAD(IFNULL(MAX(TRIM(SUBSTRING(codigo,7,4))),0)+1,4,0)) as codigo FROM pacientes WHERE SUBSTRING(codigo,1,6) = CONCAT(TRIM(YEAR(CURDATE())),LPAD(TRIM(MONTH(CURDATE())),2,0))");
        return $result[0]->codigo;
    }
    public function edad(Paciente $pacientes)
    {

        $sarro = Paciente::select("fechanacimiento")
            ->get();
        $edad = $sarro;
        $fecha = time() - strtotime($edad);

        $edad = floor($fecha / 31556926);

        return $edad;
    }
    private function getCorrelativo()
    {
        $result = DB::select("SELECT CONCAT(TRIM(YEAR(CURDATE())), LPAD(TRIM(MONTH(CURDATE())), 2, '0'), LPAD(IFNULL(MAX(TRIM(SUBSTRING(codigo, 7, 4))), 0) + 1, 4, '0')) as codigo FROM pacientes WHERE SUBSTRING(codigo, 1, 6) = CONCAT(TRIM(YEAR(CURDATE())), LPAD(TRIM(MONTH(CURDATE())), 2, '0'))");
        return $result[0]->codigo;
    }
    

    public function storePaciente(Request $request)
    {
        try {
            $paciente = new Paciente();
            $paciente->codigo = $this->getCorrelativo();
            $paciente->nombreCom = $request->nombreCom;
            $paciente->fechaNacimiento = $request->fechaNacimiento;
            $paciente->numTel = $request->numTel;
            $paciente->fechaRegistro = now();
            $paciente->user_id = $request->user_id; // Asignar el ID del usuario autenticado
            if ($paciente->save()) {
                session(['pacienteGuardado' => true]);
                return redirect()->route('welcome')->with('success', 'Paciente creado exitosamente. Ahora puedes agendar una cita.');
            } else {
                return redirect()->back()->with('error', 'Error al guardar el paciente. Por favor, inténtalo de nuevo.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error inesperado. Por favor, inténtalo de nuevo más tarde.');
        }
    }



    public function crearPaciente()
    {
        // Consulta SQL para obtener información del usuario y su paciente asociado
        $result = DB::select('SELECT b.id, b.nombreCom, p.email, p.name 
                              FROM users p 
                              INNER JOIN pacientes b 
                              WHERE b.user_id = p.id 
                              AND p.id = :user_id', ['user_id' => Auth::user()->id]);

        // Verificar si el resultado está vacío
        if (empty($result)) {
            // Si no hay paciente asociado, redirigir al formulario para crear un nuevo paciente
            return view('paciente');
        } else {
            // Si hay paciente asociado, redirigir a la página de citas
            return redirect()->route('cita');
        }
    }

    public function verificarPaciente()
    {
        // Verificar si el usuario tiene un paciente asociado
        $tienePaciente = Paciente::where('user_id', Auth::user()->id)->exists();

        return response()->json(['tienePaciente' => $tienePaciente]);
    }
}
