<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ingresos_suministro', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_suministro')
                  ->constrained('suministros')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->date('fecha_ingreso');
            $table->unsignedInteger('cantidad');
            $table->timestamps();
            
            // Índice para búsquedas por fecha
            $table->index('fecha_ingreso');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingresos_suministro');
    }
};
