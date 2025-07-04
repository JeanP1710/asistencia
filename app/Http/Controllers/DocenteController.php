<?php

namespace App\Http\Controllers;

use App\Http\Requests\Docente\StoreDocenteRequest;
use App\Http\Requests\Docente\UpdateDocenteRequest;
use App\Models\Docente;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function store(StoreDocenteRequest $request)
    {
        $docente = Docente::create([
            'numero_dni'          => $request->numero_dni,
            'codigo'              => $request->codigo,
            'apellido_paterno'    => $request->apellido_paterno,
            'apellido_materno'    => $request->apellido_materno,
            'nombres'             => $request->nombres,
            'telefono'            => $request->telefono,
            'profesion_id'        => $request->profesion_id,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Docente Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $docente = Docente::where('id', $request->id)->first();
        return $docente;
    }
    public function showByCode(Request $request)
    {
        $docente = Docente::with('profesion:id,descripcion')
        ->where('codigo', $request->codigo)
        ->first();
        return $docente;
    }

    public function update(UpdateDocenteRequest $request)
    {
        $request->validated();
        $docente = Docente::where('id',$request->id)->first();
        $docente->codigo = $request->codigo;
        $docente->numero_dni = $request->numero_dni;
        $docente->apellido_paterno = $request->apellido_paterno;
        $docente->apellido_materno = $request->apellido_materno;
        $docente->nombres = $request->nombres;
        $docente->profesion_id = $request->profesion_id;
        $docente->telefono = $request->telefono;
        $docente->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Docente modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $docente = Docente::where('id', $request->id)->first();
        $docente->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Docente eliminado satisfactoriamente'
        ],200);
    }

    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Docente::with('profesion:id,descripcion')
        ->where(function ($query) use ($buscar) {
            $query->where('apellido_paterno', 'LIKE', '%'.$buscar.'%')
                  ->orWhere('apellido_materno', 'LIKE', '%'.$buscar.'%')
                  ->orWhere('nombres', 'LIKE', '%'.$buscar.'%')
                  ->orWhere('numero_dni', 'LIKE', '%'.$buscar.'%');
        })
        ->when($request->profesion_id, function ($query) use ($request) {
            return $query->where('profesion_id', $request->profesion_id);
        })
        ->orderBy('apellido_paterno', 'ASC')
        ->paginate($paginacion);
    }

    public function cambiarEstado(Request $request){
        $user = Docente::find($request->id);
        if($user->es_activo==0){
            $user->es_activo=1;
        }else{
            $user->es_activo=0;
        }
        $user->save();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Estado Cambiado'
        ],200);
    }
    public function reporte(Request $request){
        return Docente::with('profesion:id,nombre')
        ->withCount('deudas')
        ->when($request->profesion_id, function ($query) use ($request) {
            return $query->where('profesion_id', $request->programa_id);
        })
        ->orderBy('apellido_paterno', 'ASC')
        ->get();
    }
}
