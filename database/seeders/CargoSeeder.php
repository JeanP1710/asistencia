<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\Colegio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cargos = [
            ['nombre' => 'DIRECTOR DE UNIDAD DE GESTION EDUCATIVA LOCAL'],
            ['nombre' => 'JEFE DE GESTION PEDAGOGICA'],
            ['nombre' => 'JEFE DE GESTION INSTITUCIONAL'],
            ['nombre' => 'JEFE DE GESTION ADMINISTRATIVA'],
            ['nombre' => 'JEFE DE LABORATORIO'],
            ['nombre' => 'ESPECIALISTA EN EDUCACION'],
            ['nombre' => 'ESPECIALISTA DE CONVIVENCIA ESCOLAR DE LA UGEL'],
            ['nombre' => 'TECNICO ADMINISTRATIVO I'],
            ['nombre' => 'TECNICO ADMINISTRATIVO'],
            ['nombre' => 'TRABAJADOR DE SERVICIO'],
            ['nombre' => 'PERSONAL DE VIGILANCIA'],
            ['nombre' => 'PERSONAL DE LIMPIEZA Y MANTENIMIENTO'],
            ['nombre' => 'PERSONAL DE MANTENIMIENTO'],
            ['nombre' => 'PROFESIONAL EN PSICOLOGIA'],
            ['nombre' => 'PSICOLOGO(A)'],
            ['nombre' => 'PROFESIONAL III PARA EQUIPO ITINERANTE DE CONVIVENCIA ESCOLAR'],
            ['nombre' => 'PROMOTORA EDUCATIVA COMUNAL'],
            ['nombre' => 'PROFESIONAL EN TECNOLOGIA MEDICA CON MENCION EN TERAPIA FISICA PARA LOS PROGRAMAS DE INTERVENCION TEMPRANA'],
            ['nombre' => 'PROFESOR'],
            ['nombre' => 'PROFESOR - EDUCACION FISICA'],
            ['nombre' => 'PROFESOR - IP'],
            ['nombre' => 'PROFESOR COORDINADOR'],
            ['nombre' => 'COORDINADOR PEDAGOGICO'],
            ['nombre' => 'COORDINADOR(A) DE INNOVACION Y SOPORTE TECNOLOGICO'],
            ['nombre' => 'SUB-DIRECTOR I.E.'],
            ['nombre' => 'DIRECTOR I.E.'],
            ['nombre' => 'SUPERVISOR'],
            ['nombre' => 'AUXILIAR DE EDUCACION'],
            ['nombre' => 'AUXILIAR DE BIBLIOTECA'],
            ['nombre' => 'AUXILIAR DE LABORATORIO'],
            ['nombre' => 'AUXILIAR DE SISTEMA ADMINISTRATIVO'],
            ['nombre' => 'SECRETARIA'],
            ['nombre' => 'SECRETARIA II'],
        ];



        foreach ($cargos as $cargos) {
            Cargo::firstOrCreate($cargos);
        }
    }
}
