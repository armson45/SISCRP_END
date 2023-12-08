<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedenteMedico extends Model
{
    use HasFactory;
    protected $table="antecedentes_medicos";

    public function paciente(){
        return $this->belongsTo(Paciente::class);
    }
}
