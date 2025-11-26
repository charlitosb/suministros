<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsuarioSeeder::class,
            MarcaSeeder::class,
            CategoriaSeeder::class,
            TipoEquipoSeeder::class,
            EquipoSeeder::class,
            SuministroSeeder::class,
            IngresoSuministroSeeder::class,
            InstalacionSuministroSeeder::class,
        ]);
    }
}
