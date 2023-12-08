<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    use HasFactory;
    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }
    public function historial_trabajos(){
        return $this->hasMany(HistorialTrabajo::class);
    }
}
