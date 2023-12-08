<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;
    protected $table="pacientes";    

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function citas(){
        return $this->hasMany(Cita::class);
    }
    public function antecedentes_medicos(){
        return $this->hasMany(AntecedenteMedico::class);
    }
    public function odontogramas(){
        return $this->hasMany(Odontograma::class);
    }
    public function radiografias(){
        return $this->hasMany(Radiografia::class);
    }

}
