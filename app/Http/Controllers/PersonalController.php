<?php

namespace App\Http\Controllers;

use App\Http\Requests\Alumno\StoreAlumnoRequest;
use App\Http\Requests\Alumno\UpdateAlumnoRequest;
use App\Models\Personal;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PersonalController extends Controller
{
    public function store(StoreAlumnoRequest $request)
    {
        $alumno = Personal::create([
            'numero_dni'          => $request->numero_dni,
            'nombres'             => $request->nombres,
            'apellido_paterno'    => $request->apellido_paterno,
            'apellido_materno'    => $request->apellido_materno,
            'fecha_nacimiento'    => $request->fecha_nacimiento,
            'telefono'            => $request->telefono,
            'cargo'               => $request->cargo,
            'tipo_trabajador_id'  => $request->tipo_trabajador_id,
            'email'               => $request->email,

        ]);
        $user = User::where('name', $alumno->numero_dni);
        // if (!$user) {
        User::firstorCreate([
            'name'          => $alumno->numero_dni,
            'password'      => hash::make($alumno->numero_dni),
            'role_id'       => Role::where('nombre', 'Personal')->value('id'),
        ]);                    
        // }
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Grupo Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $alumno = Personal::where('id', $request->id)->first();
        return $alumno;
    }
    public function showByCode(Request $request){
        $alumno = Personal::with(['programa:id,nombre', 'deudas'])->where('codigo', $request->codigo)->first();
        return $alumno;
    }

    public function update(UpdateAlumnoRequest $request)
    {
        $request->validated();
        $alumno = Personal::where('id',$request->id)->first();
        $alumno->numero_dni = $request->numero_dni;
        $alumno->apellido_paterno = $request->apellido_paterno;
        $alumno->apellido_materno = $request->apellido_materno;
        $alumno->nombres = $request->nombres;
        $alumno->programa_id = $request->programa_id;
        $alumno->ciclo_academico = $request->ciclo_academico;
        $alumno->turno = $request->turno;
        $alumno->seccion = $request->seccion;
        $alumno->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Alumno modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request){
        $grupomenu = Personal::where('id', $request->id)->first();
        $grupomenu->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Grupo eliminado satisfactoriamente'
        ],200);
    }

    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Personal::with('programa:id,nombre')
        ->withCount('deudas')
        ->where(function ($query) use ($buscar) {
            $query->where('apellido_paterno', 'LIKE', '%'.$buscar.'%')
                  ->orWhere('apellido_materno', 'LIKE', '%'.$buscar.'%')
                  ->orWhere('nombres', 'LIKE', '%'.$buscar.'%')
                  ->orWhere('numero_dni', 'LIKE', '%'.$buscar.'%');
        })
        ->when($request->programa_id, function ($query) use ($request) {
            return $query->where('programa_id', $request->programa_id);
        })
        ->when($request->ciclo, function ($query) use ($request) {
            return $query->where('ciclo_academico', $request->ciclo);
        })
        ->when($request->turno, function ($query) use ($request) {
            return $query->where('turno', $request->turno);
        })
        ->when($request->seccion, function ($query) use ($request) {
            return $query->where('seccion', $request->seccion);
        })
        ->orderBy('apellido_paterno', 'ASC')
        ->paginate($paginacion);
    }
    public function cambiarEstado(Request $request){
        $user = Personal::find($request->id);
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
    public function cambiarEstadoDeuda(Request $request){
        $alumno = Personal::find($request->id);
        $alumno->debe=$request->debe;
        $alumno->save();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cambiado'
        ],200);
    }
    public function reporte(Request $request){
        return Personal::with('programa:id,nombre')
        ->withCount('deudas')
        ->when($request->programa_id, function ($query) use ($request) {
            return $query->where('programa_id', $request->programa_id);
        })
        ->when($request->ciclo, function ($query) use ($request) {
            return $query->where('ciclo_academico', $request->ciclo);
        })
        ->when($request->debe, function ($query) use ($request) {
            if($request->debe==1){
                return $query->where('deudas_count', '>=', 1);
            }else{
                return $query->where('deudas_count', '=', 0);
            }
        })
        ->orderBy('apellido_paterno', 'ASC')
        ->get();
    }
}
