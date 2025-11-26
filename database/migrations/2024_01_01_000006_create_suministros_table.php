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
        Schema::create('suministros', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 255);
            $table->decimal('precio', 10, 2)->default(0.00);
            $table->foreignId('id_marca')
                  ->constrained('marcas')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreignId('id_categoria')
                  ->constrained('categorias')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->foreignId('id_tipo_equipo')
                  ->constrained('tipos_equipo')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->unsignedInteger('stock')->default(0);
            $table->timestamps();
            
            // Índice para búsquedas por stock
            $table->index('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suministros');
    }
};
