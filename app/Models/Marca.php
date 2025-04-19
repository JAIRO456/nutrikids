<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $table = 'marcas';
    protected $primaryKey = 'id_marca';

    protected $fillable = [
        'id_marca',
        'marca',
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_producto');
    }
}
