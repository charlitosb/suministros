<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Marca extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'marcas';

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'descripcion',
    ];

    /**
     * Obtener los suministros de esta marca.
     */
    public function suministros(): HasMany
    {
        return $this->hasMany(Suministro::class, 'id_marca');
    }
}
