<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios'; // Asegúrate de que este sea el nombre correcto de tu tabla
    protected $primaryKey = 'id'; // Asegúrate de que este sea el nombre correcto del campo de ID
    public $incrementing = true; // Indica que el campo de ID es auto-incremental
    protected $keyType = 'int'; // Define que el ID es de tipo entero
    public $timestamps = false; // Si no estás usando timestamps, asegúrate de poner esto en false

    protected $fillable = [
        'nombre',
        'tipo_usuario',
        'email',
        'password',
    ];

}
