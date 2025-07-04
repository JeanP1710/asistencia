<?php

namespace App\Http\Controllers;

use App\Http\Requests\Persona\StorePersonaRequest;
use App\Http\Requests\Persona\UpdatePersonaRequest;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;
class PersonaController extends Controller
{
    public function store(StorePersonaRequest $request)
    {
        $request->validated();
        $Persona = Persona::create([
            'dni' => $request->dni,
            'ape_paterno' => $request->ape_paterno,
            'ape_materno' => $request->ape_materno,
            'nombres' => $request->nombres,
            'tipo' => $request->tipo,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Persona Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $menu = Persona::where('id', $request->id)->first();
        return $menu;
    }
    public function update(UpdatePersonaRequest $request)
    {
        $request->validated();

        $menu = Persona::where('id',$request->id)->first();

        $menu->dni           = $request->dni;
        $menu->ape_paterno   = $request->ape_paterno;
        $menu->ape_materno   = $request->ape_materno;
        $menu->nombres       = $request->nombres;
        $menu->tipo          = $request->tipo;
        $menu->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Menu modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $persona = Persona::where('id', $request->id)->first();
        $persona->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Persona eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $personas = Persona::get();
        return $personas;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Persona::where(DB::raw("CONCAT(ape_paterno, ' ', ape_materno, ' ', nombres)"), 'LIKE', '%' . $buscar . '%')
        ->orWhere('dni', 'LIKE', '%' . $buscar . '%')
        ->paginate($paginacion);
    }
    public function encriptar(Request $request){
        $success['token'] = 'mitokengenerado123';
        $success['sede_id'] = $request->id;
        $success = JWT::encode($success,env('VITE_SECRET_KEY'),'HS256');



        
        return $success;
    }
}
