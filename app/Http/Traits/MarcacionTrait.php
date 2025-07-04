<?php
namespace App\Http\Traits;

use App\Models\Alumno;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait MarcacionTrait
{
    public static function marcacionesporFiltros(Request $request){
        $query = DB::table('marcacions')
        ->join('alumnos', 'marcacions.alumno_id', '=', 'alumnos.id')
        ->join('sedes', 'marcacions.sede_id', '=', 'sedes.id')
        ->join('programas', 'alumnos.programa_id', '=', 'programas.id')
        ->where('sedes.id', $request->sede_id)
        ->where('alumnos.numero_dni', $request->dni)
        ->whereYear('marcacions.fecha', $request->anho)
        ->whereMonth('marcacions.fecha', $request->mes)
        ->select([
            'alumnos.numero_dni as numero_dni',
            DB::raw("concat(alumnos.apellido_paterno, ' ', alumnos.apellido_materno, ', ', alumnos.nombres) as apenom"),
            'alumnos.ciclo_academico as ciclo',
            'sedes.nombre as sede',
            DB::raw("DATE_FORMAT(marcacions.fecha, '%d-%m-%Y') as fecha"),
            'marcacions.hora as hora',
            'marcacions.tipo as tipo',
            'programas.nombre as programa'
        ])->orderBy('alumnos.apellido_paterno', 'asc');
        $result = $query->get();
        return $result;
    }
    public static function reporteMensual(Request $request){
        $anio = $request->anho;
        $mes=$request->mes;
        $programa_id=$request->programa_id;
        $ciclo=$request->ciclo;
        $turno=$request->turno;
        $seccion=$request->seccion;
        $alumnos = Alumno::select(
            'alumnos.id',
            'alumnos.numero_dni',
            DB::raw("CONCAT(alumnos.apellido_paterno, ' ', alumnos.apellido_materno, ' ', alumnos.nombres) AS nombre_completo"),
            DB::raw("programas.nombre as programa"),
            'alumnos.ciclo_academico',
            'alumnos.turno',
            'alumnos.seccion',
            DB::raw("MAX(CASE WHEN dia_mes.nro = 1 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_1"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 2 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_2"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 3 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_3"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 4 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_4"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 5 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_5"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 6 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_6"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 7 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_7"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 8 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_8"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 9 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_9"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 10 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_10"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 11 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_11"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 12 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_12"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 13 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_13"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 14 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_14"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 15 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_15"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 16 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_16"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 17 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_17"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 18 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_18"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 19 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_19"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 20 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_20"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 21 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_21"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 22 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_22"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 23 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_23"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 24 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_24"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 25 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_25"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 26 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_26"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 27 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_27"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 28 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_28"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 29 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_29"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 30 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_30"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 31 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND alumnos.id = marcacions.alumno_id) END) AS dia_31")
        )
        ->join('dia_mes', DB::raw('1'), '=', DB::raw('1'))
        ->join('programas', 'alumnos.programa_id', '=', 'programas.id')
        ->where('alumnos.programa_id', $programa_id)
        ->where('alumnos.es_activo', 1)
        ->when($ciclo, function ($query) use ($ciclo) {
            return $query->where('ciclo_academico', $ciclo);
        })
        ->when($turno, function ($query) use ($turno) {
            return $query->where('turno', $turno);
        })
        ->when($seccion, function ($query) use ($seccion) {
            return $query->where('seccion', $seccion);
        })
        ->groupBy('alumnos.id', 'alumnos.numero_dni', 'nombre_completo')
        ->orderBy('nombre_completo', 'asc')
        ->get();
        return $alumnos;
    }
    public static function reporteMensualDocente(Request $request){
        $anio = $request->anho;
        $mes=$request->mes;
        $docentes = Docente::select(
            'docentes.id',
            'docentes.numero_dni',
            DB::raw("CONCAT(docentes.apellido_paterno, ' ', docentes.apellido_materno, ' ', docentes.nombres) AS nombre_completo"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 1 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_1"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 2 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_2"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 3 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_3"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 4 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_4"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 5 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_5"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 6 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_6"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 7 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_7"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 8 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_8"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 9 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_9"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 10 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_10"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 11 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_11"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 12 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_12"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 13 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_13"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 14 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_14"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 15 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_15"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 16 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_16"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 17 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_17"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 18 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_18"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 19 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_19"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 20 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_20"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 21 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_21"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 22 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_22"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 23 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_23"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 24 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_24"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 25 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_25"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 26 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_26"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 27 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_27"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 28 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_28"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 29 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_29"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 30 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_30"),
            DB::raw("MAX(CASE WHEN dia_mes.nro = 31 THEN (SELECT MIN(hora) FROM marcacion_docentes WHERE DAY(fecha) = dia_mes.nro AND MONTH(fecha) = $mes AND YEAR(fecha)=$anio AND docentes.id = marcacion_docentes.docente_id) END) AS dia_31")
        )
        ->join('dia_mes', DB::raw('1'), '=', DB::raw('1'))
        ->where('docentes.es_activo', 1)
        ->groupBy('docentes.id', 'docentes.numero_dni', 'nombre_completo')
        ->orderBy('nombre_completo', 'asc')
        ->get();
        return $docentes;
    }
    /*consulta*/


//     SELECT 
//     a.id, 
//     a.numero_dni, 
//     CONCAT(a.nombres, ' ', a.apellido_paterno, ' ', a.apellido_materno) AS nombre_completo,
//     MAX(CASE WHEN dm.nro = 1 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id ) END ) AS dia_1,
//     MAX(CASE WHEN dm.nro = 2 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id ) END ) AS dia_2,
//     MAX(CASE WHEN dm.nro = 3 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id ) END ) AS dia_3,
//     MAX(CASE WHEN dm.nro = 4 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id ) END ) AS dia_4,
//     MAX(CASE WHEN dm.nro = 5 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id ) END ) AS dia_5,
//     MAX(CASE WHEN dm.nro = 6 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id ) END ) AS dia_6,
//     MAX(CASE WHEN dm.nro = 7 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id ) END ) AS dia_7,
//     MAX(CASE WHEN dm.nro = 8 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id ) END ) AS dia_8,
//     MAX(CASE WHEN dm.nro = 9 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id ) END ) AS dia_9,
//     MAX(CASE WHEN dm.nro = 10 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id ) END ) AS dia_10,
//     MAX(CASE WHEN dm.nro = 11 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_11,
//     MAX(CASE WHEN dm.nro = 12 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_12,
//     MAX(CASE WHEN dm.nro = 13 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_13,
//     MAX(CASE WHEN dm.nro = 14 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_14,
//     MAX(CASE WHEN dm.nro = 15 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_15,
//     MAX(CASE WHEN dm.nro = 16 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_16,
//     MAX(CASE WHEN dm.nro = 17 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_17,
//     MAX(CASE WHEN dm.nro = 18 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_18,
//     MAX(CASE WHEN dm.nro = 19 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_19,
//     MAX(CASE WHEN dm.nro = 20 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_20,
//     MAX(CASE WHEN dm.nro = 21 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_21,
//     MAX(CASE WHEN dm.nro = 22 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_22,
//     MAX(CASE WHEN dm.nro = 23 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_23,
//     MAX(CASE WHEN dm.nro = 24 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_24,
//     MAX(CASE WHEN dm.nro = 25 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_25,
//     MAX(CASE WHEN dm.nro = 26 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_26,
//     MAX(CASE WHEN dm.nro = 27 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_27,
//     MAX(CASE WHEN dm.nro = 28 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_28,
//     MAX(CASE WHEN dm.nro = 29 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_29,
//     MAX(CASE WHEN dm.nro = 30 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_30,
//     MAX(CASE WHEN dm.nro = 31 THEN (SELECT MIN(hora) FROM marcacions WHERE DAY(fecha) = dm.nro AND a.id = marcacions.alumno_id) END) AS dia_31
//   FROM 
//     alumnos AS a
//   JOIN 
//     dia_mes dm ON 1 = 1
//   where a.programa_id=2
//   GROUP BY 
//     a.id, a.numero_dni, nombre_completo;

}