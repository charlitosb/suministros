<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'usuarios';

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'usuario',
        'nombre',
        'password',
    ];

    /**
     * Los atributos que deben ocultarse para la serialización.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Los atributos que deben convertirse.
     */
    protected $casts = [
        'password' => 'hashed',
    ];
}
