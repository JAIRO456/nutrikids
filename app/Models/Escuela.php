<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Escuela extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_escuela',
        'nombre_escuela',
        // 'imagen',
    ];
}
