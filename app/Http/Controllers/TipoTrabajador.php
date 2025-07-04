<?php

namespace App\Http\Controllers;
use App\Models\TipoTrabajador;
use Illuminate\Http\Request;

class ProgramaController extends Controller
{
    public function store(Request $request)
    {
        $request->validated();
        if($request->padre_id !='' || $request->padre_id != null){
            $orden = TipoTrabajador::maximoHijoId($request->padre_id);
        }else{
            $orden = TipoTrabajador::maximoPadreId();
        }
        $menu = TipoTrabajador::create([
            'nombre'    => $request->nombre,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Menu Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $menu = TipoTrabajador::where('id', $request->id)->first();
        return $menu;
    }
    public function update(Request $request)
    {
        $menu = TipoTrabajador::where('id',$request->id)->first();
        $menu->nombre           = $request->nombre;
        $menu->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Menu modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $menu = TipoTrabajador::where('id', $request->id)->first();
        $menu->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $programas = TipoTrabajador::get();
        return $programas;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return TipoTrabajador::with(['padre:id,nombre', 'grupo:id,titulo'])
        ->whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }
}
