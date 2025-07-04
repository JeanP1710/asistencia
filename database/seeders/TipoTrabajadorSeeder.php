<?php

namespace Database\Seeders;

use App\Models\TipoTrabajador;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoTrabajadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipotrabajador = [
            ['nombre' => 'DOCENTE'],
            ['nombre' => 'ADMINISTRATIVO'],
            ['nombre' => 'CAS'],
            ['nombre' => 'PEC'],
        ];
        foreach($tipotrabajador as $row){
            TipoTrabajador::firstOrCreate($row);
        }
    }
}
