<?php

namespace App\Http\Controllers;

use App\Models\Profesion;
use Illuminate\Http\Request;

class ProfesionController extends Controller
{
    public function store(StoreMenuRequest $request)
    {

    }
    public function show(Request $request)
    {
        $menu = Profesion::where('id', $request->id)->first();
        return $menu;
    }
    public function update(UpdateMenuRequest $request)
    {

    }

    public function destroy(Request $request)
    {
        $menu = Profesion::where('id', $request->id)->first();
        $menu->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $profesiones = Profesion::get();
        return $profesiones;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Profesion::with(['padre:id,nombre', 'grupo:id,titulo'])
        ->whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }
}
