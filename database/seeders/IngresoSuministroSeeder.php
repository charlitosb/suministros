<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngresoSuministroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingresos = [
            ['id_suministro' => 1, 'fecha_ingreso' => '2024-01-15', 'cantidad' => 10],
            ['id_suministro' => 2, 'fecha_ingreso' => '2024-01-20', 'cantidad' => 15],
            ['id_suministro' => 3, 'fecha_ingreso' => '2024-02-01', 'cantidad' => 20],
            ['id_suministro' => 4, 'fecha_ingreso' => '2024-02-10', 'cantidad' => 25],
            ['id_suministro' => 5, 'fecha_ingreso' => '2024-02-15', 'cantidad' => 8],
        ];

        foreach ($ingresos as $ingreso) {
            // Insertar el ingreso
            DB::table('ingresos_suministro')->insert([
                'id_suministro' => $ingreso['id_suministro'],
                'fecha_ingreso' => $ingreso['fecha_ingreso'],
                'cantidad' => $ingreso['cantidad'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Actualizar el stock del suministro
            DB::table('suministros')
                ->where('id', $ingreso['id_suministro'])
                ->increment('stock', $ingreso['cantidad']);
        }
    }
}
