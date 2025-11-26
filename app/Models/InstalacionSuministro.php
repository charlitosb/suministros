<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\ValidationException;

class InstalacionSuministro extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'instalaciones_suministro';

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'fecha_instalacion',
        'id_suministro',
        'id_equipo',
        'cantidad',
    ];

    /**
     * Los atributos que deben convertirse.
     */
    protected $casts = [
        'fecha_instalacion' => 'date',
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
     * Obtener el equipo asociado.
     */
    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'id_equipo');
    }

    /**
     * Boot del modelo para manejar eventos.
     */
    protected static function boot()
    {
        parent::boot();

        // Antes de crear, verificar que haya stock disponible
        static::creating(function ($instalacion) {
            $suministro = Suministro::find($instalacion->id_suministro);
            $cantidad = $instalacion->cantidad ?? 1;
            
            if (!$suministro) {
                throw ValidationException::withMessages([
                    'id_suministro' => ['El suministro seleccionado no existe.']
                ]);
            }
            
            if (!$suministro->tieneStock($cantidad)) {
                throw ValidationException::withMessages([
                    'id_suministro' => ["No hay stock suficiente. Solicitado: {$cantidad}, Disponible: {$suministro->stock}"]
                ]);
            }
        });

        // Al crear una instalación, decrementar el stock según la cantidad
        static::created(function ($instalacion) {
            $cantidad = $instalacion->cantidad ?? 1;
            $instalacion->suministro->decrementarStock($cantidad);
        });

        // Al eliminar una instalación, incrementar el stock según la cantidad
        static::deleting(function ($instalacion) {
            $cantidad = $instalacion->cantidad ?? 1;
            $instalacion->suministro->increment('stock', $cantidad);
        });
    }
}
