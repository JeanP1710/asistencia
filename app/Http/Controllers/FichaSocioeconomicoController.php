<?php

namespace App\Http\Controllers;

use App\Http\Requests\FichaSocio\StoreFichaSocioRequest;
use App\Http\Requests\LoginAlumno\LoginAlumnoRequest;
use App\Models\Alumno;
use App\Models\AptitudesAlumno;
use App\Models\CaracteristicasAcademicasAlumno;
use App\Models\CaracteristicasEconomica;
use App\Models\CaracteristicasParentale;
use App\Models\CaracteristicasVivienda;
use App\Models\FichaSocioEconomico;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
class FichaSocioEconomicoController extends Controller
{
    public function login (LoginAlumnoRequest $request){

        $credenciales = ['name' => $request->codigo, 'password' => $request->password, 'es_activo' => 1];
        $user = User::where('name',$request->codigo)->first();
        if($user){
            if(Hash::check($request->password,$user->password)){
                if(auth()->attempt($credenciales)){
                    $user = auth()->user();
                    $alumno = Alumno::where('numero_dni',$user->dni)->first();
                    $success['alumno'] = $alumno;

                    $success=JWT::encode($success,env('VITE_SECRET_KEY'), 'HS256');
                    return response()->json($success,200);

                } else {
                    return response()->json([
                        'errors' => ['name' => 'Usuario Suspendido']
                    ],422);
                }
            }
            else {
                return response()->json([
                    'errors' => ['password' => 'Contraseña Incorrecta']
                ],422);
            }

        }else{
            return response()->json([
                'ok' => 0,
                'mensaje' => 'Alumno no encontrado'
            ],200);
        }

    }
    public function logout(){
        auth()->guard('web')->logout();
        return response()->json([
            'ok' => 1,
            'mensaje' =>'Sessión cerrada Satisfactoriamiente'
        ], 200);
    }
    public function store(StoreFichaSocioRequest $request)
    {
        $nro = FichaSocioEconomico::getNextNro($request->alumno_id);
        $registrado = FichaSocioEconomico::create([
            'nro_ficha' => $nro,
            'alumno_id' => $request->alumno_id,
            'fecha'     => $request->fecha,
            'hora'      => $request->hora,
        ]);

        $alumno = Alumno::where('id', $request->alumno_id)
        ->update([
            'numero_dni'          => $request->numero_dni,
            'codigo'              => $request->numero_dni,
            'apellido_paterno'    => $request->apellido_paterno,
            'apellido_materno'    => $request->apellido_materno,
            'nombres'             => $request->nombres,
            'programa_id'         => $request->programa_id,
            'ciclo_academico'     => $request->ciclo_academico,
            'turno'               => $request->turno,
            'seccion'             => $request->seccion,
        ]);

        CaracteristicasAcademicasAlumno::updateOrCreate([
            [
                'alumno_id' => $alumno->id,
            ],
            [
                'programa_id' => $request->programa_id,
                'colegio_id' => $request->colegio_id,
                'medio_difusion_id' => $request->medio_difusion_id,
                'modalidad_id' => $request->modalidad_id,
                'semestre_id' => $request->semestre_id,
                'ciclo_academico' => $request->ciclo_academico,
                'debe' => $request->debe,
                'turno' => $request->turno,
                'seccion' => $request->seccion,
            ]
        ]);

        CaracteristicasEconomica::updateOrCreate(
            [
                'alumno_id' => $alumno->id,
            ],
            [
                'es_trabajador' => $request->es_trabajador,
                'tipo_trabajo' => $request->tipo_trabajo,
                'nombre_empresa' => $request->nombre_empresa,
                'ingreso' => $request->ingreso,
                'turno_trabajo' => $request->turno_trabajo,
                'donde_come' => $request->donde_come,
            ]
        );

        CaracteristicasVivienda::updateOrCreate(
            [
                'alumno_id' => $alumno->id,
            ],
            [
                'tipo_id' => $request->tipo_id,
                'agua' => $request->agua,
                'telefono' => $request->telefono,
                'computadora' => $request->computadora,
                'desague' => $request->desague,
                'internet' => $request->internet,
                'energia_electrica' => $request->energia_electrica,
                'tv_cable' => $request->tv_cable,
                'ubicacion_domicilio_id' => $request->ubicacion_domicilio_id,
            ]
        );

        CaracteristicasParentale::updateOrCreate(
            [
                'alumno_id' => $alumno->id,
            ],
            [
                'padre' => $request->padre,
                'madre' => $request->madre,
                'padre_edad' => $request->padre_edad,
                'madre_edad' => $request->madre_edad,
                'padre_grado_instruccion_id' => $request->padre_grado_instruccion_id,
                'madre_grado_instruccion_id' => $request->madre_grado_instruccion_id,
            ]
        );

        AptitudesAlumno::updateOrCreate(
            [
                'alumno_id' => $alumno->id,
            ],
            [
                'voley' => $request->voley,
                'futbol' => $request->futbol,
                'basket' => $request->basket,
                'natacion' => $request->natacion,
                'tenis' => $request->tenis,
                'atletismo' => $request->atletismo,
                'ciclismo' => $request->ciclismo,
                'quieres_pertenecer_deportivo' => $request->quieres_pertenecer_deportivo,
                'quieres_pertenecer_religioso' => $request->quieres_pertenecer_religioso,
                'quieres_pertenecer_cultural' => $request->quieres_pertenecer_cultural,
                'quieres_pertenecer_artistico' => $request->quieres_pertenecer_artistico,
            ]
        );

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registrado satisfactoriamente'
        ],200);
    }
    public function show(Request $request)
    {
        $menu = FichaSocioEconomico::where('id', $request->id)->first();
        return $menu;
    }
    public function update(UpdateMenuRequest $request)
    {
        $menu = FichaSocioEconomico::where('id',$request->id)->first();
        $menu->nombre           = $request->nombre;
        $menu->slug             = $request->slug;
        $menu->icono            = $request->icono;
        $menu->padre_id         = $request->padre_id;
        $menu->grupo_id         = $request->grupo_id;
        $menu->orden            = $request->orden;
        $menu->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Menu modificado satisfactoriamente'
        ],200);
    }

    public function destroy(Request $request)
    {
        $menu = FichaSocioEconomico::where('id', $request->id)->first();
        $menu->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $menus = FichaSocioEconomico::with('grupo:id,titulo')->get();
        return $menus;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return FichaSocioEconomico::with(['padre:id,nombre', 'grupo:id,titulo'])->whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }
}
