<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'estados';
    protected $primaryKey = 'id_estado';

    protected $fillable = [
        'id_estado',
        'estado',
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
