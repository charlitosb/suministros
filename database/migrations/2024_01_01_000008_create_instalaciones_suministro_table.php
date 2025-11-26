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
        Schema::create('instalaciones_suministro', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_instalacion');
            $table->foreignId('id_suministro')
                  ->constrained('suministros')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreignId('id_equipo')
                  ->constrained('equipos')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->integer('cantidad')->default(1);
            $table->timestamps();
            
            // Índice para búsquedas por fecha
            $table->index('fecha_instalacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instalaciones_suministro');
    }
};
