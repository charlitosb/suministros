<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipo extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'equipos';

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'numero_serie',
        'descripcion',
        'id_tipo',
    ];

    /**
     * Obtener el tipo de equipo.
     */
    public function tipoEquipo(): BelongsTo
    {
        return $this->belongsTo(TipoEquipo::class, 'id_tipo');
    }

    /**
     * Obtener las instalaciones de este equipo.
     */
    public function instalaciones(): HasMany
    {
        return $this->hasMany(InstalacionSuministro::class, 'id_equipo');
    }

    /**
     * Accessor para mostrar descripción completa con tipo.
     */
    public function getDescripcionCompletaAttribute(): string
    {
        return $this->numero_serie . ' - ' . $this->descripcion;
    }
}
