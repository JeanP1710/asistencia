<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class otrosAlumnosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->getOutput()->writeln('Iniciando Importación de Alumnos...');
        $csvFile = fopen(base_path('archivos/alumnos_29_08.csv'), 'r');
        $this->command->getOutput()->writeln("Importando Datos... ");
        $firstLine = true;
        while(($fila = fgetcsv($csvFile, 3000, "|")) !== false) {
            if(!$firstLine)
            {
                $registro = explode(";",(string)$fila[0]);
                $nroDocumento = str_replace(' ', "", $registro[0]);
                $nombres = $registro[1];
                $apellido_paterno = $registro[2];
                $apellido_materno = $registro[3];
                $programa_id = $registro[5];
                $alumno = Alumno::where('codigo', $nroDocumento)->orWhere('numero_dni', $nroDocumento)->first();
                if (!$alumno) {
                    $alumno = new Alumno();
                    $alumno->codigo = $nroDocumento;
                    $alumno->numero_dni = $nroDocumento; // Asignar el mismo valor a 'numero_dni'
                    $alumno->apellido_paterno = $apellido_paterno;
                    $alumno->apellido_materno = $apellido_materno;
                    $alumno->nombres = $nombres;
                    $alumno->programa_id = $programa_id;
                    $alumno->ciclo_academico = 'I';
                    $alumno->save();
                }else{
                    $alumno->numero_dni = $nroDocumento;
                    $alumno->apellido_paterno = $apellido_paterno;
                    $alumno->apellido_materno = $apellido_materno;
                    $alumno->nombres = $nombres;
                    $alumno->programa_id = $programa_id;
                    $alumno->ciclo_academico = 'I';
                    $alumno->save();
                }
                $user = User::where('name', $nroDocumento);
                if (!$user) {
                    User::firstorCreate([
                        'name'          => $nroDocumento,
                        'password'      => hash::make($nroDocumento),
                        'role_id'       => Role::where('nombre', 'Alumno')->value('id'),
                    ]);                    
                }

            }
            $firstLine = false;
        }
    }
}
