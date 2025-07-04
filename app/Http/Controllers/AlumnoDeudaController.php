<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlumnoDeuda\StoreAlumnoDeudaRequest;
use App\Models\Alumno;
use App\Models\AlumnoDeuda;
use Illuminate\Http\Request;

class AlumnoDeudaController extends Controller
{
    public function store(StoreAlumnoDeudaRequest $request)
    {
        $request->validated();
        $menu = AlumnoDeuda::create([
            'alumno_id' => $request->alumno_id,
            'mes'       => $request->mes ,
            'anio'      => $request->anio ,            
            'nombreMes' => $request->nombreMes,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Deuda Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $registro = AlumnoDeuda::where('id', $request->id)->first();
        return $registro;
    }
    public function todos(Request $request)
    {
        $registros = AlumnoDeuda::where('alumno_id', $request->alumno_id)->get();
        return $registros;

    }

    public function destroy(Request $request)
    {
        $menu = AlumnoDeuda::where('id', $request->id)->first();
        $menu->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Deuda eliminado satisfactoriamente'
        ],200);
    }
}
