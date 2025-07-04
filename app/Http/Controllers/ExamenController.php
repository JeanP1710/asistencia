<?php

namespace App\Http\Controllers;

use App\Models\Alternativa;
use App\Models\AlternativaPregunta;
use App\Models\Alumno;
use App\Models\Examen;
use App\Models\ExamenAlumno;
use App\Models\historyLeaveExamen;
use App\Models\Pregunta;
use App\Models\PreguntaMarcada;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamenController extends Controller
{
    public function store(StoreGrupoMenuRequest $request)
    {
        $grupomenu = Examen::create([
            'titulo'    => $request->titulo,
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Grupo Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $examen = Examen::where('id', $request->id)->first();
        return $examen;
    }
    public function validarRendidoExamen(Request $request){
        $usuario=User::where('id',Auth::user()->id)->first();
        $alumno_id=Alumno::where('codigo', $usuario->name)->value('id');
        $examen_alumno = ExamenAlumno::where('examen_id', $request->id)
        ->where('alumno_id', $alumno_id)->where('estado', 'Finalizado')
        ->first();
        if($examen_alumno){
            return 1;
        }else{
            return 0;
        }
    }
    public function examenesPorAlumno(Request $request){
        $examenes = ExamenAlumno::with('examen:id,titulo')
        ->where('alumno_id', $request->alumno_id)
        ->whereHas('examen', function ($query) {
            $query->where('estado', 1);
        })
        ->orderBy('fecha', 'desc')
        ->get();
        return $examenes;
    }

    public function obtenerPregunta(Request $request){
        $usuario=User::where('id',Auth::user()->id)->first();
        $alumno_id=Alumno::where('codigo', $usuario->name)->value('id');
        $examen_alumno = ExamenAlumno::where('alumno_id', $alumno_id)->where('examen_id', $request->id)->first();
        if($examen_alumno){
            $registros = PreguntaMarcada::where('examen_alumno_id', $examen_alumno->id)->get();
            $indice=$registros->count()+1;
            $idsPreguntasMarcadas = $registros->pluck('pregunta_id')->toArray();
            $pregunta = Pregunta::select('id', 'text', 'punto')
            ->with('alternativas')
            ->where('examen_id', $request->id)
            ->whereNotIn('id', $idsPreguntasMarcadas)
            ->inRandomOrder()
            ->first();

        }else{
            $examen_alumno = ExamenAlumno::firstorCreate([
                'examen_id' => $request->id,
                'alumno_id'=> $alumno_id,
                'nota' => 0,
                'fecha' => Carbon::now()->format('Y-m-d'),
                'hora' =>  Carbon::now()->format('H:i:s'),
            ]);
            $indice=1;
            $pregunta = Pregunta::select('id', 'text', 'punto')
            ->with('alternativas')
            ->where('examen_id', $request->id)
            ->inRandomOrder()->first();
        }
        return response()->json([
            'ok' => 1,
            'examen_alumno' => $examen_alumno,
            'pregunta' => $pregunta,
            'indice'    => $indice
        ],200);
    }
    public function validarPregunta(Request $request){
        $estado='Rindiendo';
        $mensaje='Enviado';
        $nota=0;
        $examen_alumno = ExamenAlumno::where('id', $request->examen_alumno_id)->first();
        if($examen_alumno->estado=='Finalizado'){
            return response()->json([
                'ok' => 1,
                'indice' => 10,
                'estado' => 'Finalizado',
                'mensaje' => '',
                'nota'  => $examen_alumno->nota
            ],200);
        }
        $pregunta = Pregunta::where('id', $request->id)->first();
        if($pregunta->codrespuesta==$request->codrespuesta){
            $punto=$pregunta->punto;
            $examen_alumno->nota+=$pregunta->punto;
        }else{
            $punto=0;
        }
        PreguntaMarcada::create([
            'examen_alumno_id' => $request->examen_alumno_id,
            'pregunta_id'      => $request->id,
            'pregunta'         => $pregunta->text,
            'marcada'   => $request->codrespuesta,
            'punto'     => $punto
        ]);
        
        if($request->indice>=10){
            $estado='Finalizado';
            $examen_alumno->estado=$estado;
            $mensaje='SU NOTA ES '.$examen_alumno->nota;
            $nota=$examen_alumno->nota;
        }
        $examen_alumno->save();

        return response()->json([
            'ok' => 1,
            'indice' => $request->indice+1,
            'estado' => $estado,
            'mensaje' => $mensaje,
            'nota'  => $nota
        ],200);
    }
    public function destroy(Request $request)
    {
        $examen = Examen::where('id', $request->id)->first();
        $examen->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Grupo eliminado satisfactoriamente'
        ],200);
    }
    public function cargarExamenAlumnos(Request $request){
        $registros = ExamenAlumno::with('alumno:id,numero_dni,nombres,apellido_paterno,apellido_materno')
        ->where('examen_id', $request->examen_id)
        ->join('alumnos', 'examen_alumnos.alumno_id', '=', 'alumnos.id')
        ->orderBy('alumnos.apellido_paterno', 'asc')
        ->select('examen_alumnos.*')
        ->get();
        return $registros;
    }
    public function eliminarExamenAlumnos(Request $request){
        $registro = ExamenAlumno::where('id', $request->id)->first();
        $registro->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro eliminado satisfactoriamente'
        ],200);
    } 
    public function detalleExamen(Request $request){
        // $preguntamarcada = PreguntaMarcada::where('examen_alumno_id', $request->id)->get();
        // return $preguntamarcada;
        $preguntasMarcadas = PreguntaMarcada::select('pregunta_marcadas.*', 'ap.alternativa_id', 'ap.TEXT', 'ap.cod', 'preguntas.respuesta')
        ->join('preguntas', 'pregunta_marcadas.pregunta_id', '=', 'preguntas.id')
        ->joinSub(
            // Subconsulta
            AlternativaPregunta::select('alternativa_pregunta.pregunta_id', 'alternativa_pregunta.alternativa_id', 'alternativas.TEXT', 'alternativas.cod')
                ->join('alternativas', 'alternativa_pregunta.alternativa_id', '=', 'alternativas.id')
                ->toBase(), // Convierte a consulta base
            'ap',
            'pregunta_marcadas.pregunta_id', '=', 'ap.pregunta_id'
        )
        ->whereColumn('pregunta_marcadas.marcada', 'ap.cod')
        ->where('examen_alumno_id', $request->id)
        ->get();
        // Retorna los resultados
        return $preguntasMarcadas;

    }
    public function registrarDistraccionExamen(Request $request){
        $examen_id = $request->examen_id;
        $alumno_id = $request->alumno_id;
        historyLeaveExamen::firstOrCreate([
            'examen_id' => $examen_id,
            'alumno_id' => $alumno_id,
            'fecha' => Carbon::now()->format('Y-m-d'),
            'hora' =>  Carbon::now()->format('H:i:s'),
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registrado'
        ],200);
    }
    public function verAlternativaMarcada(Request $request){
        $alternativa = Alternativa::with('preguntas')
        ->whereHas('preguntas', function($q) use($request) {
            $q->where('id', $request->pregunta_id);
        })
        ->where('alternativa.cod', $request->cod)
        ->first();
    }
    public function todos(){
        $examenes = Examen::get();
        return $examenes;
    }
    public function todosactivos(){
        $examenes = Examen::where('estado', 1)->get();
        return $examenes;
    }    
    public function listos_Rendir(Request $request){
        $alumnoId = $request->alumno_id;
        $examenes = Examen::select('examens.id', 'examens.titulo', 'examens.fecha', 'examens.estado')
        ->leftJoin('examen_alumnos', function ($join) use ($alumnoId) {
            $join->on('examens.id', '=', 'examen_alumnos.examen_id')
                 ->where('examen_alumnos.alumno_id', '=', $alumnoId);
        })
        ->where('examens.estado', 1)
        //->whereNull('examen_alumnos.examen_id')
        ->get();
        return $examenes;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Examen::where('titulo', 'LIKE', '%' . $buscar . '%')
        ->paginate($paginacion);
    }
}
