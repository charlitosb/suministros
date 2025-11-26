<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('marcas')->insert([
            ['descripcion' => 'HP', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion' => 'Epson', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion' => 'Logitech', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion' => 'Dell', 'created_at' => now(), 'updated_at' => now()],
            ['descripcion' => 'Canon', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
