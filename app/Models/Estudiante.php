<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';
    protected $primaryKey = 'documento_est';

    protected $fillable = [
        'documento_est',
        'nombre_est',
        'apellido_est',
        'email_est',
        'telefono_est',
        'imagen_est',
        'id_escuela',
        'documento',
        'id_estado',
    ];

    public function escuelas()
    {
        return $this->belongsTo(Escuela::class, 'id_escuela');
    }

    public function estados()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'documento');
    }
}
