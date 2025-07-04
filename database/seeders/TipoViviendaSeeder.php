<?php

namespace Database\Seeders;

use App\Models\TipoVivienda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoViviendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposDeVivienda = [
            "Casa",
            "Departamento / Apartamento",
            "Cuarto en vivienda compartida",
            "Quinta (casas agrupadas, común en algunos países)",
            "Condominio",
            "Casa prefabricada",
            "Rancho / Casa rústica",
            "Choza o cabaña",
            "Vivienda improvisada (hecha de materiales no durables)",
            "Albergue o refugio temporal",
            "Otra (para casos que no se ajusten a lo anterior)"
        ];
        foreach ($tiposDeVivienda as $tipo) {
            TipoVivienda::firstOrCreate(['nombre' => $tipo]);
        }
    }
}
