<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('equipos')->insert([
            [
                'numero_serie' => 'LAP-HP-2024-001',
                'descripcion' => 'Laptop HP ProBook 450 G8',
                'id_tipo' => 1, // Laptop
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'numero_serie' => 'PC-DELL-2024-001',
                'descripcion' => 'PC Dell OptiPlex 7090',
                'id_tipo' => 2, // PC de Escritorio
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'numero_serie' => 'IMP-EPS-2024-001',
                'descripcion' => 'Impresora Epson L3250',
                'id_tipo' => 3, // Impresora
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'numero_serie' => 'MON-DELL-2024-001',
                'descripcion' => 'Monitor Dell 24 pulgadas',
                'id_tipo' => 4, // Monitor
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'numero_serie' => 'LAP-DELL-2024-002',
                'descripcion' => 'Laptop Dell Latitude 5520',
                'id_tipo' => 1, // Laptop
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
