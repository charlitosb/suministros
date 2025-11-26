<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoEquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_equipo')->insert([
            ['descripcion' => 'Laptop', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion' => 'PC de Escritorio', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion' => 'Impresora', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion' => 'Monitor', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion' => 'Scanner', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
