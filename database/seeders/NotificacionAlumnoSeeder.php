<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\NotificacionAlumno;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificacionAlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NotificacionAlumno::firstorCreate([
            'alumno_id' => Alumno::where('numero_dni', '72793837')->value('id'),
            'tipo_alerta'   => 'alert-warning',
            'mensaje'       => 'No pago la pension'
        ]);
    }
}
