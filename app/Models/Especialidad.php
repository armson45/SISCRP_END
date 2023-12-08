<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    use HasFactory;
    protected $table = "especialidades";
    public function tratamientos()
    {
        return $this->hasMany(Tratamiento::class);
    }

    public function cita()
    {
        return $this->hasMany(Cita::class);
    }

    public function doctores()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_especialidad', 'especialidad_id', 'doctor_id');
    }
}
