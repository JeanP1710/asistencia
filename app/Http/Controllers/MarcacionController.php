<?php

namespace App\Http\Controllers;

use App\Http\Requests\marcaciones\StoreMarcacionRequest;
use App\Http\Requests\Reporte\BuscarReportRequest;
use App\Models\personal;
use App\Models\Marcacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarcacionController extends Controller
{
    public function __construct() {
        date_default_timezone_set('America/Lima');
    }
    public function marcoHoy(Request $request){
        $fecha = $request->fecha;
        $personal_id = $request->personal_id;
        $marcacionhoy = Marcacion::where('fecha', $request->fecha)->where('personal_id', $personal_id)->latest()->first();
        if($marcacionhoy){
            return response()->json([
                'ok' => 1
            ],200);
        }else{
            return response()->json([
                'ok' => 0
            ],200);
        }
    }
    public function store(StoreMarcacionRequest $request)
    {
        $numero_dni = $request->numero_dni;
        $fecha = $request->fecha;
        $hora = $request->hora;
        $horaActual = Carbon::now();
        
        $personal = Personal::with([
            'tipo_trabajador:id,nombre', 
            'cargo:id,nombre', 
        ])
        ->where('numero_dni', $numero_dni)
        ->firstOrFail();
        
        $marcacionHoy = Marcacion::where('fecha', $fecha)
            ->where('personal_id', $personal->id)
            ->latest()
            ->first();
        
        if ($marcacionHoy && Carbon::parse($marcacionHoy->hora)->diffInMinutes($horaActual) <= 5) {
            return response()->json([
                'ok' => 2,
                'mensaje' => 'No puede marcar seguido',
            ], 200);
        }

        $tipo = ($marcacionHoy && $marcacionHoy->tipo === 'Ingreso') ? 'Salida' : 'Ingreso';
        $marcacion = Marcacion::create([
            'fecha'      => $fecha,
            'hora'       => $hora,
            'tipo'       => $tipo,
            'personal_id'  => $personal->id,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'personal registrado satisfactoriamente',
            'personal'  => $personal,
        ], 200);
    }


    public function reporteMarcaciones(Request $request){
        $fecha = Carbon::create($request->anio, $request->mes_numero, 1);
        $ultimoDiaDelMes = $fecha->copy()->endOfMonth()->format('d');

        $registros = Marcacion::reporteMarcacionesPorPeronal($request);

        $diasDelMes = [];
        while ($fecha->month == $request->mes_numero) {
            $nombreDia = $fecha->isoFormat('dddd');
            $nombreDia= strtoupper($nombreDia);
            $dia = $fecha->day;           
            $diasDelMes[] = [
                'dia'       => $dia,
                'fecha'     => str_pad($dia, 2, '0', STR_PAD_LEFT).'-'.str_pad($request->mes_numero, 2, '0', STR_PAD_LEFT),
                'nombreDia' => $nombreDia,
            ];
            $fecha->addDay();
        }

        return response()->json([
            'mes'       => $fecha->month,
            'anho'      => $request->anio,
            'diasDelMes' => $diasDelMes,
            'registros' => $registros
        ],200);

    }
    public function marcacionReporte(Request $request){

        return Marcacion::marcacionesporFiltros($request);

    }
    public function marcacionMensual(BuscarReportRequest $request){
        $registros = Marcacion::reporteMensual($request);
        Carbon::setLocale('es');
        $fecha = Carbon::create($request->anho, $request->mes, $request->desde);
        $diasDelMes = [];
        while ($fecha->month == $request->mes) {
            $nombreDia = $fecha->isoFormat('dddd');
            $nombreDia = strtoupper(iconv('UTF-8', 'ASCII//TRANSLIT', $nombreDia));
            $nombreDia = substr($nombreDia, 0, 3);
            $dia = $fecha->day;
            if (!$fecha->isSunday() && $fecha->day<=$request->hasta) {
                $diasDelMes[] = [
                    'dia'       => $dia,
                    'nombreDia' => $nombreDia,
                ];
            }
            $fecha->addDay();
        }
        return response()->json([
            'personals' => $registros,
            'diasDelMes' => $diasDelMes,
        ],200);
    }

    public function marcacionMensualDocente(Request $request){
        $registros = Marcacion::reporteMensualDocente($request);
        Carbon::setLocale('es');
        $fecha = Carbon::create($request->anho, $request->mes, $request->desde);
        $diasDelMes = [];
        while ($fecha->month == $request->mes) {
            $nombreDia = $fecha->isoFormat('dddd');
            $nombreDia = strtoupper(iconv('UTF-8', 'ASCII//TRANSLIT', $nombreDia));
            $nombreDia = substr($nombreDia, 0, 3);
            $dia = $fecha->day;
            if (!$fecha->isSunday() && $fecha->day<=$request->hasta) {
                $diasDelMes[] = [
                    'dia'       => $dia,
                    'nombreDia' => $nombreDia,
                ];
            }
            $fecha->addDay();
        }
        return response()->json([
            'docentes' => $registros,
            'diasDelMes' => $diasDelMes,
        ],200);        
    }

    public function destroy(Request $request)
    {
        $marcacion = Marcacion::where('id', $request->id)->first();
        $marcacion->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo eliminado satisfactoriamente'
        ],200);
    }

    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Marcacion::with([
            'Personal:id,numero_dni,apellido_paterno,apellido_materno,nombres,tipo_trabajador_id',
            'personal.tipo_trabajador:id,nombre'
            ])
            ->whereHas('personal', function ($query) use ($buscar) {
                $query->where('numero_dni', 'like', '%' . $buscar . '%')
                    ->orWhere(DB::raw("CONCAT(apellido_paterno, ' ', apellido_materno, ' ', nombres)"), 'like', '%' . $buscar . '%');
            })
        ->orderBy('fecha', 'desc')
        ->orderBy('hora', 'desc')
        ->paginate($paginacion);
    }
    public function listarPorFiltro(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Marcacion::with([
            'Personal:id,numero_dni,apellido_paterno,apellido_materno,nombres,tipo_trabajador_id',
            'personal.tipo_trabajador:id,nombre'
        ])
        ->whereHas('personal', function ($query) use ($buscar, $request) {
            $query->where(function ($query) use ($buscar) {
                $query->where('numero_dni', 'like', '%' . $buscar . '%')
                      ->orWhere(DB::raw("CONCAT(apellido_paterno, ' ', apellido_materno, ' ', nombres)"), 'like', '%' . $buscar . '%');
            })
            ->when($request->tipo_trabajador_id, function ($query) use ($request) {
                return $query->where('tipo_trabajador_id', $request->tipo_trabajador_id);
            })
            ->where('fecha', $request->fecha)
            ;
        })
        ->orderBy('fecha', 'desc')
        ->orderBy('hora', 'desc')
        ->paginate($paginacion);
    }    
        //central
        //eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbiI6Im1pdG9rZW5nZW5lcmFkbzEyMyIsInNlZGVfaWQiOiIxIn0.V3Gs-b_DmfZGylzkHSLCb3rvMEOyOqyksd6Ntsdt-4M

        //general
        //eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbiI6Im1pdG9rZW5nZW5lcmFkbzEyMyIsInNlZGVfaWQiOiIyIn0.BYb_ZJTknWF8lG_bBtn4VGoKv6qKFk4PfwrxzalFYGg
}
