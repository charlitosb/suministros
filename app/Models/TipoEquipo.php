<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoEquipo extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'tipos_equipo';

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'descripcion',
    ];

    /**
     * Obtener los equipos de este tipo.
     */
    public function equipos(): HasMany
    {
        return $this->hasMany(Equipo::class, 'id_tipo');
    }

    /**
     * Obtener los suministros para este tipo de equipo.
     */
    public function suministros(): HasMany
    {
        return $this->hasMany(Suministro::class, 'id_tipo_equipo');
    }
}
