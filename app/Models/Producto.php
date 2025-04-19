<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto';
    protected $primaryKey = 'id_producto';

    protected $fillable = [
        'id_producto',
        'nombre_prod',
        'descripcion',
        'precio',
        'imagen_prod',
        'cantidad_alm',
        'id_categoria',
        'id_marca',
    ];

    public function categorias()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function marcas()
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }
}
