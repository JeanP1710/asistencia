<?php

namespace App\Http\Controllers;

use App\Http\Requests\Registro\StoreRegistroRequest;
use App\Http\Requests\Registro\UpdateRegistroRequest;
use App\Models\Persona;
use App\Models\Registro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CertificadoController extends Controller
{
    public function store(StoreRegistroRequest $request)
    {
        $persona = Persona::where('dni', $request->dni)->first();
        if(!$persona){
            $persona = Persona::firstorCreate([
                'dni' => $request->dni,
                'ape_paterno' => $request->ape_paterno,
                'ape_materno' => $request->ape_materno,
                'nombres' => $request->nombres,
                'tipo' => $request->tipo,
            ]);
        }
        $registro = Registro::create([
            'fecha' => $request->fecha,
            'codigo' => $request->codigo,
            'persona_id' => $persona->id,
            'curso_tomado' => $request->curso_tomado,
            'lugar' => $request->lugar,
            'comentario' => $request->comentario,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $certificado = Registro::with('persona:id,dni,ape_paterno,ape_materno,nombres,tipo')
        ->where('id', $request->id)->first();
        return $certificado;
    }

    public function update(UpdateRegistroRequest $request)
    {
        $request->validated();

        $grupomenu = Registro::where('id',$request->id)->first();

        $grupomenu->titulo           = $request->titulo;
        $grupomenu->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Grupo modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $grupomenu = Registro::where('id', $request->id)->first();
        $grupomenu->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Grupo eliminado satisfactoriamente'
        ],200);
    }

    public function registrosPorPersona(Request $request){
        $registros = Registro::where('persona_id', $request->persona_id)->get();
        return $registros;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Registro::with('persona:id,dni,ape_paterno,ape_materno,nombres,tipo')
        // ->select(
        //     'fecha',
        //     'codigo',
        //     'persona_id',
        //     'curso_tomado',
        //     'lugar',
        //     'comentario',
        //     'persona.dni',
        //     DB::raw("concat(ape_paterno,' ',ape_materno,' ',nombres) AS apenom"),
        //     'persona.tipo'
        //     )
        ->whereHas('persona', function ($query) use ($buscar) {
            $query->where(DB::raw("CONCAT(ape_paterno, ' ', ape_materno, ' ', nombres)"), 'LIKE', '%' . $buscar . '%')
            ->orWhere('dni', 'LIKE', '%' . $buscar . '%');
        })
        ->paginate($paginacion);
    }
}
