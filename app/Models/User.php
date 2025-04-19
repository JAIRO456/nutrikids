<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'usuarios';
    protected $primaryKey = 'documento';

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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function escuelas()
    {
        return $this->belongsTo(Escuela::class, 'id_escuela');
    }

    public function estados()
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'documento_est');
    }
}
