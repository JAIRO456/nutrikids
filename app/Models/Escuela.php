<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Escuela extends Model
{
    use HasFactory;

    protected $table = 'escuelas';
    protected $primaryKey = 'id_escuela';

    protected $fillable = [
        'id_escuela',
        'nombre_escuela',
        'imagen_esc',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'documento');
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'documento_est');
    }
}
