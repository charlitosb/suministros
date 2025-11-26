<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuministroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suministros')->insert([
            [
                'descripcion' => 'Toner HP 107A Negro',
                'precio' => 450.00,
                'id_marca' => 1, // HP
                'id_categoria' => 1, // Toner
                'id_tipo_equipo' => 3, // Impresora
                'stock' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Mouse Logitech M185 Inalámbrico',
                'precio' => 125.00,
                'id_marca' => 3, // Logitech
                'id_categoria' => 2, // Mouse
                'id_tipo_equipo' => 2, // PC de Escritorio
                'stock' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Teclado Logitech K120 USB',
                'precio' => 95.00,
                'id_marca' => 3, // Logitech
                'id_categoria' => 3, // Teclado
                'id_tipo_equipo' => 2, // PC de Escritorio
                'stock' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Cartucho Epson T544 Negro',
                'precio' => 85.00,
                'id_marca' => 2, // Epson
                'id_categoria' => 4, // Cartucho de Tinta
                'id_tipo_equipo' => 3, // Impresora
                'stock' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'descripcion' => 'Toner Canon 121 Negro',
                'precio' => 520.00,
                'id_marca' => 5, // Canon
                'id_categoria' => 1, // Toner
                'id_tipo_equipo' => 3, // Impresora
                'stock' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
