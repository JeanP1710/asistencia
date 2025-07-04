<?php

namespace Database\Seeders;

use App\Models\Profesion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfesionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programas = [
            ['descripcion'    => 'Licenciado'],
        ];
        foreach($programas as $row){
            Profesion::firstOrCreate($row);
        }
    }
}
