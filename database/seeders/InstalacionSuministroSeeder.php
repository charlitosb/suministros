<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstalacionSuministroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instalaciones = [
            ['fecha_instalacion' => '2024-01-25', 'id_suministro' => 1, 'id_equipo' => 3],
            ['fecha_instalacion' => '2024-01-28', 'id_suministro' => 2, 'id_equipo' => 2],
            ['fecha_instalacion' => '2024-02-05', 'id_suministro' => 3, 'id_equipo' => 2],
            ['fecha_instalacion' => '2024-02-12', 'id_suministro' => 4, 'id_equipo' => 3],
            ['fecha_instalacion' => '2024-02-20', 'id_suministro' => 2, 'id_equipo' => 5],
        ];

        foreach ($instalaciones as $instalacion) {
            // Insertar la instalación
            DB::table('instalaciones_suministro')->insert([
                'fecha_instalacion' => $instalacion['fecha_instalacion'],
                'id_suministro' => $instalacion['id_suministro'],
                'id_equipo' => $instalacion['id_equipo'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Reducir el stock del suministro
            DB::table('suministros')
                ->where('id', $instalacion['id_suministro'])
                ->decrement('stock', 1);
        }
    }
}
