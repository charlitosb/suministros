<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IngresoSuministro extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'ingresos_suministro';

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'id_suministro',
        'fecha_ingreso',
        'cantidad',
    ];

    /**
     * Los atributos que deben convertirse.
     */
    protected $casts = [
        'fecha_ingreso' => 'date',
        'cantidad' => 'integer',
    ];

    /**
     * Obtener el suministro asociado.
     */
    public function suministro(): BelongsTo
    {
        return $this->belongsTo(Suministro::class, 'id_suministro');
    }

    /**
     * Boot del modelo para manejar eventos.
     */
    protected static function boot()
    {
        parent::boot();

        // Al crear un ingreso, incrementar el stock
        static::created(function ($ingreso) {
            $ingreso->suministro->incrementarStock($ingreso->cantidad);
        });

        // Al eliminar un ingreso, decrementar el stock
        static::deleting(function ($ingreso) {
            $suministro = $ingreso->suministro;
            if ($suministro->stock >= $ingreso->cantidad) {
                $suministro->decrement('stock', $ingreso->cantidad);
            }
        });
    }
}
