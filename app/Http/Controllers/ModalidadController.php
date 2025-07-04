<?php

namespace App\Http\Controllers;

use App\Http\Requests\Modalidad\StoreModalidadRequest;
use App\Http\Requests\Modalidad\UpdateModalidadRequest;
use App\Models\Modalidad;
use Illuminate\Http\Request;

class ModalidadController extends Controller
{
    public function store(StoreModalidadRequest $request)
    {
        $modalidad = Modalidad::create([
            'nombre'    => $request->nombre,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Modalidad Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $modalidad = Modalidad::where('id', $request->id)->first();
        return $modalidad;
    }
    public function update(UpdateModalidadRequest $request)
    {
        $modalidad = Modalidad::where('id',$request->id)->first();
        $modalidad->nombre           = $request->nombre;
        $modalidad->save();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Modalidad modificado satisfactoriamente'
        ],200);
    }
    public function destroy(Request $request)
    {
        $modalidad = Modalidad::where('id', $request->id)->first();
        $modalidad->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Modalidad eliminado satisfactoriamente'
        ],200);
    }
    public function todos(){
        $modalidads = Modalidad::with('grupo:id,titulo')->get();
        return $modalidads;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Modalidad::where('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }
}
