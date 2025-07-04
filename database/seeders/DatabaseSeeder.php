<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            GrupoMenuSeeder::class,
            MenuSeeder::class,
            ProgramaSeeder::class,
            SedeSeeder::class,
            MensajeMotivadorSeeder::class,
            TipoViviendaSeeder::class,
            AlumnoSeeder::class,
            UbigeoSeeder::class,
            GradoInstruccionSeeder::class,
            ColegioSeeder::class,
            MedioDifusionSeeder::class,
        ]);
    }
}
