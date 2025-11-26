<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'categorias';

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'nombre_categoria',
    ];

    /**
     * Obtener los suministros de esta categoría.
     */
    public function suministros(): HasMany
    {
        return $this->hasMany(Suministro::class, 'id_categoria');
    }
}
