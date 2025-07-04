<?php

namespace Database\Seeders;

use App\Models\MedioDifusion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedioDifusionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medios = [
            ['nombre' => 'Facebook'],
            ['nombre' => 'Instagram'],
            ['nombre' => 'TikTok'],
            ['nombre' => 'Radio local'],
            ['nombre' => 'Televisión'],
            ['nombre' => 'Volantes'],
            ['nombre' => 'Ferias educativas'],
            ['nombre' => 'WhatsApp'],
            ['nombre' => 'Recomendación de un amigo'],
            ['nombre' => 'Correo electrónico'],
            ['nombre' => 'Página web del instituto'],
            ['nombre' => 'Carteles o banners en la ciudad'],
            ['nombre' => 'Visita al colegio'],
            ['nombre' => 'Llamada telefónica'],
            ['nombre' => 'Publicidad en transporte público'],
            ['nombre' => 'YouTube'],
        ];

        foreach ($medios as $medio) {
            MedioDifusion::firstOrCreate($medio);
        }
    }
}
