<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialTrabajo extends Model
{
    use HasFactory;
    protected $table="historial_trabajos";
    public function trabajo(){
        return $this->belongsTo(Trabajo::class);
    }
    public function cita(){
        return $this->belongsTo(Cita::class);
    }
}
