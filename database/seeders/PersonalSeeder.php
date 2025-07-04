<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\Personal;
use App\Models\TipoTrabajador;
use DateTime;
use Illuminate\Database\Seeder;

class PersonalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(base_path('archivos/personals.csv'), 'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ';')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Personals...');
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de Personals... ");

        $progressBar->start();
        $csvFile2 = fopen(base_path('archivos/personals.csv'), 'r');
        // Leer y limpiar bien el header
        $header = fgetcsv($csvFile2, 2000, ';');
        $header = array_map(function($value) {
            return trim(str_replace("\xEF\xBB\xBF", '', $value));
        }, $header);
        while(($fila  = fgetcsv($csvFile2,2000,";")) !== false) {
            if (count($fila) == count($header)) {
                $fila = array_map(fn($value) => mb_convert_encoding(trim($value), 'UTF-8', 'auto'), $fila);
                $data = array_combine($header, $fila);       

                $numero_dni         = $data['DNI'];
                $nombres     = trim($data['NOMBRES']);
                $apellido_paterno   = strtoupper(trim($data['APELLIDO_PATERNO']));
                $apellido_materno   = strtoupper(trim($data['APELLIDO_MATERNO']));
                $fecha_raw = trim($data['FECHA_DE_NACIMIENTO']);
                $fecha_nacimiento = DateTime::createFromFormat('d/m/Y', $fecha_raw);

                if ($fecha_nacimiento) {
                    $fecha_nacimiento = $fecha_nacimiento->format('Y-m-d');
                } else {
                    $fecha_nacimiento = null; // o manejar el error si la fecha es inválida
                }

                $cargo           = strtoupper(trim($data['CARGO']));
                $tipo_trabajador    = trim($data['TIPO_DE_TRABAJADOR']);
                $email   = strtoupper(trim($data['EMAIL']));              
            } else {
                continue;
            }
            $tipo_trabajador_id = TipoTrabajador::where('nombre', $tipo_trabajador)->value('id');
        $this->command->getOutput()->writeln($cargo);
            $personal = Personal::firstOrCreate(
                ['numero_dni' => $numero_dni],
                [
                    'nombres'               => $nombres,
                    'apellido_paterno'      => $apellido_paterno,
                    'apellido_materno'      => $apellido_materno,
                    'tipo_trabajador_id'    => TipoTrabajador::where('nombre',$tipo_trabajador)->value('id'),
                    'fecha_nacimiento'      => $fecha_nacimiento,
                    'cargo'                 => Cargo::where('nombre',$cargo)->value('id'),
                    'email'                 => $email,
                    // Aquí podrías agregar otros campos también
                ]
            );            
            $progressBar->advance();
        }

        fclose($csvFile2);
        $progressBar->finish();
        $this->command->getOutput()->writeln("");
        $this->command->getOutput()->writeln("Importación Finalizada");
    }
}
