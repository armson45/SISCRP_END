<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    use HasFactory;
    public function citas(){
        return $this->hasMany(Cita::class);
    }
    public function especialidad(){
        return $this->belongsTo(Especialidad::class);
    }

}
