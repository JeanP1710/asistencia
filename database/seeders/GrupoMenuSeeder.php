<?php

namespace Database\Seeders;

use App\Models\GrupoMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupos = [
            ['titulo' => 'Sistema'],
            ['titulo' => 'Certificados'],
            ['titulo' => 'Asistencia'],
            ['titulo' => 'Evaluacion'],
        ];

        foreach($grupos as $grupo){
            GrupoMenu::firstorCreate($grupo);            
        }
    }
}
