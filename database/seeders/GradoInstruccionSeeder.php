<?php

namespace Database\Seeders;

use App\Models\GradoInstruccion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradoInstruccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grados = [
            ['id' => 1, 'nombre' => 'Sin instrucción'],
            ['id' => 2, 'nombre' => 'Educación Primaria Incompleta'],
            ['id' => 3, 'nombre' => 'Educación Primaria Completa'],
            ['id' => 4, 'nombre' => 'Educación Secundaria Incompleta'],
            ['id' => 5, 'nombre' => 'Educación Secundaria Completa'],
            ['id' => 6, 'nombre' => 'Técnico Superior'],
            ['id' => 7, 'nombre' => 'Universitario Incompleto'],
            ['id' => 8, 'nombre' => 'Universitario Completo'],
            ['id' => 9, 'nombre' => 'Postgrado / Maestría'],
            ['id' => 10, 'nombre' => 'Doctorado'],
        ];
        
        foreach ($grados as $grado) {
            GradoInstruccion::firstOrCreate(['id' => $grado['id']], $grado);
        }
    }
}
