<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categorias')->insert([
            ['nombre_categoria' => 'Toner', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_categoria' => 'Mouse', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_categoria' => 'Teclado', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_categoria' => 'Cartucho de Tinta', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_categoria' => 'Cable USB', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
