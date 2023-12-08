<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{

    protected $fillable = [
        'dia',
        'hora',
        'precio',
        'paciente_id',
        'tratamiento_id',
    ];

    protected $dates = [
        'dia',
        'hora',
    ];

    use HasFactory;
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }
    public function historial_trabajos()
    {
        return $this->hasMany(HistorialTrabajo::class);
    }




    public function getCitasDelMesPorEspecialidad($especialidadId)
    {
        return $this->whereMonth('dia', now()->month)
            ->whereYear('dia', now()->year)
            ->where('especialidad_id', $especialidadId)
            ->get();
    }
}
