<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserAlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alumnos = Alumno::get();
        foreach($alumnos as $alumno){
            $existingUser = User::where('name', $alumno->numero_dni)->first();

            if (!$existingUser) {
                User::create([
                    'name'      => $alumno->numero_dni,
                    'password'  => Hash::make($alumno->numero_dni),
                    'role_id'   => Role::where('nombre','Alumno')->value('id')
                ]);
            }
        }
    }
}
