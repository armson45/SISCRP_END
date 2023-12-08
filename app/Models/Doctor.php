<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $table = "doctores";
    protected $fillable = [
        'nombre',
        'numeroTel',
        'fechaRegistro',
        'user_id',
        'especialidad_id'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function trabajos()
    {
        return $this->hasMany(Trabajo::class);
    }
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    

    public function especialidades()
    {
        return $this->belongsToMany(Especialidad::class);
    }
}
