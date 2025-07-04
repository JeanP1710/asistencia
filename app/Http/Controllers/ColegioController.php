<?php

namespace App\Http\Controllers;

use App\Http\Requests\Colegio\StoreColegioRequest;
use App\Http\Requests\Colegio\UpdateColegioRequest;
use App\Models\Colegio;
use Illuminate\Http\Request;

class ColegioController extends Controller
{
    public function store(StoreColegioRequest $request)
    {
        $colegio = Colegio::create([
            'nombre'    => $request->nombre,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Colegio Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $colegio = Colegio::where('id', $request->id)->first();
        return $colegio;
    }
    public function update(UpdateColegioRequest $request)
    {
        $colegio = Colegio::where('id',$request->id)->first();
        $colegio->nombre           = $request->nombre;
        $colegio->save();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Colegio modificado satisfactoriamente'
        ],200);
    }
    public function destroy(Request $request)
    {
        $colegio = Colegio::where('id', $request->id)->first();
        $colegio->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo eliminado satisfactoriamente'
        ],200);
    }
    public function todosPorTipo(Request $request){
        $colegios = Colegio::where('tipo', $request->tipo)->get();
        return $colegios;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Colegio::where('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }
}
