<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'tipo_documento',
        'documento',
        'nombre',
        'apellido',
        'direccion',
        'telefono',
        'email',
        'estado',
    ];
}
