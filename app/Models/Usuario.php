<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = [
        'documento',
        'nombre',
        'apellido',
        'email',
        'telefono',
        'password',
        'imagen',
        'id_escuela',
        'id_rol',
        'id_estado',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }
}
