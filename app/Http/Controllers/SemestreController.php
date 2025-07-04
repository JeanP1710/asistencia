<?php

namespace App\Http\Controllers;

use App\Http\Requests\Semestre\StoreSemestreRequest;
use App\Http\Requests\Semestre\UpdateSemestreRequest;
use App\Models\Semestre;
use Illuminate\Http\Request;

class SemestreController extends Controller
{
    public function store(StoreSemestreRequest $request)
    {
        $semestre = Semestre::create([
            'nombre'    => $request->nombre,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Semestre Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $semestre = Semestre::where('id', $request->id)->first();
        return $semestre;
    }
    public function update(UpdateSemestreRequest $request)
    {
        $semestre = Semestre::where('id',$request->id)->first();
        $semestre->nombre           = $request->nombre;
        $semestre->save();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Semestre modificado satisfactoriamente'
        ],200);
    }
    public function destroy(Request $request)
    {
        $semestre = Semestre::where('id', $request->id)->first();
        $semestre->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo eliminado satisfactoriamente'
        ],200);
    }
    public function todos(){
        $semestres = Semestre::with('grupo:id,titulo')->get();
        return $semestres;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Semestre::where('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }
}
