<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedioDifusion\StoreMedioDifusionRequest;
use App\Http\Requests\MedioDifusion\UpdateMedioDifusionRequest;
use App\Models\MedioDifusion;
use Illuminate\Http\Request;

class MedioDifusionController extends Controller
{
    public function store(StoreMedioDifusionRequest $request)
    {
        $colegio = MedioDifusion::create([
            'nombre'    => $request->nombre,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Colegio Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $colegio = MedioDifusion::where('id', $request->id)->first();
        return $colegio;
    }
    public function update(UpdateMedioDifusionRequest $request)
    {
        $colegio = MedioDifusion::where('id',$request->id)->first();
        $colegio->nombre           = $request->nombre;
        $colegio->save();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Colegio modificado satisfactoriamente'
        ],200);
    }
    public function destroy(Request $request)
    {
        $colegio = MedioDifusion::where('id', $request->id)->first();
        $colegio->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo eliminado satisfactoriamente'
        ],200);
    }
    public function todos(){
        $colegios = MedioDifusion::get();
        return $colegios;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return MedioDifusion::where('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }
}
