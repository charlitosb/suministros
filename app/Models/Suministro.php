<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Suministro extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'suministros';

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'descripcion',
        'precio',
        'id_marca',
        'id_categoria',
        'id_tipo_equipo',
        'stock',
    ];

    /**
     * Los atributos que deben convertirse.
     */
    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
    ];

    /**
     * Obtener la marca del suministro.
     */
    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }

    /**
     * Obtener la categoría del suministro.
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    /**
     * Obtener el tipo de equipo del suministro.
     */
    public function tipoEquipo(): BelongsTo
    {
        return $this->belongsTo(TipoEquipo::class, 'id_tipo_equipo');
    }

    /**
     * Obtener los ingresos de este suministro.
     */
    public function ingresos(): HasMany
    {
        return $this->hasMany(IngresoSuministro::class, 'id_suministro');
    }

    /**
     * Obtener las instalaciones de este suministro.
     */
    public function instalaciones(): HasMany
    {
        return $this->hasMany(InstalacionSuministro::class, 'id_suministro');
    }

    /**
     * Incrementar el stock.
     */
    public function incrementarStock(int $cantidad): void
    {
        $this->increment('stock', $cantidad);
    }

    /**
     * Decrementar el stock.
     * Retorna false si no hay suficiente stock.
     */
    public function decrementarStock(int $cantidad = 1): bool
    {
        if ($this->stock < $cantidad) {
            return false;
        }
        
        $this->decrement('stock', $cantidad);
        return true;
    }

    /**
     * Verificar si hay stock disponible.
     */
    public function tieneStock(int $cantidad = 1): bool
    {
        return $this->stock >= $cantidad;
    }

    /**
     * Accessor para descripción completa.
     */
    public function getDescripcionCompletaAttribute(): string
    {
        return $this->descripcion . ' (' . $this->marca->descripcion . ') - Stock: ' . $this->stock;
    }
}
