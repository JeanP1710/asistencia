<?php
use App\Http\Controllers\GrupoMenuController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\MarcacionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\TipoTrabajadorController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'grupo-menu', 'middleware' => 'auth'], function () {
    Route::get('todos', [GrupoMenuController::class, 'todos']);
    Route::get('mostrar', [GrupoMenuController::class, 'show']);
    Route::post('actualizar', [GrupoMenuController::class, 'update']);
    Route::post('eliminar', [GrupoMenuController::class, 'destroy']);
    Route::post('guardar', [GrupoMenuController::class, 'store']);
    Route::get('listar', [GrupoMenuController::class, 'listar']);
});

//menu
Route::group(['prefix' => 'menu', 'middleware' => 'auth'], function () {
    Route::get('todos', [MenuController::class, 'todos']);
    Route::get('mostrar', [MenuController::class, 'show']);
    Route::post('actualizar', [MenuController::class, 'update']);
    Route::post('eliminar', [MenuController::class, 'destroy']);
    Route::post('guardar', [MenuController::class, 'store']);
    Route::get('listar', [MenuController::class, 'listar']);
});



//programa
Route::group(['prefix' => 'tipo-trabajador', 'middleware' => 'auth'], function () {
    Route::get('todos', [TipoTrabajadorController::class, 'todos']);
    Route::get('mostrar', [TipoTrabajadorController::class, 'show']);
    Route::post('actualizar', [TipoTrabajadorController::class, 'update']);
    Route::post('eliminar', [TipoTrabajadorController::class, 'destroy']);
    Route::post('guardar', [TipoTrabajadorController::class, 'store']);
    Route::get('listar', [TipoTrabajadorController::class, 'listar']);
});

//CERTIFICADO
Route::group(['prefix' => 'certificado', 'middleware' => 'auth'], function () {
    Route::get('todos', [CertificadoController::class, 'todos']);
    Route::get('mostrar', [CertificadoController::class, 'show']);
    Route::post('actualizar', [CertificadoController::class, 'update']);
    Route::post('eliminar', [CertificadoController::class, 'destroy']);
    Route::post('guardar', [CertificadoController::class, 'store']);
    Route::get('listar', [CertificadoController::class, 'listar']);
});
Route::get('certificado/registros-por-persona', [CertificadoController::class, 'registrosPorPersona']);

//USUARIOS
Route::group(['prefix' => 'usuario', 'middleware' => 'auth'], function () {
    Route::post('reset-password',[UserController::class,'resetclave']);
    Route::get('listar-habilitados',[UserController::class,'habilitados']);
    Route::get('listar-inactivos',[UserController::class,'inactivos']);
    Route::get('listar-todos',[UserController::class,'todos']);
    Route::get('mostrar', [UserController::class, 'show']);
    Route::post('actualizar', [UserController::class, 'update']);
    Route::post('eliminar', [UserController::class, 'destroy']);
    Route::post('guardar', [UserController::class, 'store']);
    Route::get('cambiar-estado',[UserController::class,'cambiarEstado']);
    Route::get('mostrar-por-nombre',[UserController::class,'mostraNombre']);
    Route::post('cambiar-clave',[UserController::class,'cambiarclaveperfil']);
});

//ROLE
Route::group(['prefix' => 'rol', 'middleware' => 'auth'], function () {
    Route::get('todos', [RoleController::class, 'todos']);
    Route::get('mostrar', [RoleController::class, 'show']);
    Route::post('actualizar', [RoleController::class, 'update']);
    Route::post('eliminar', [RoleController::class, 'destroy']);
    Route::post('guardar', [RoleController::class, 'store']);
    Route::get('listar', [RoleController::class, 'listar']);
    Route::get('menu-roles',[RoleController::class,'mostrarRoleMenus']);
    Route::get('mostrar-menus',[RoleController::class,'mostrarMenus']);
    Route::post('menu-role-guardar',[RoleController::class,'guardarRoleMenu']);
});

//MARCACION
Route::group(['prefix' => 'marcacion'], function () {
    Route::get('mostrar', [MarcacionController::class, 'show']);
    Route::post('actualizar', [MarcacionController::class, 'update']);
    Route::post('eliminar', [MarcacionController::class, 'destroy']);
    Route::post('guardar', [MarcacionController::class, 'store']);
    Route::get('listar', [MarcacionController::class, 'listar']);
    Route::post('listar-por-filtro', [MarcacionController::class, 'listarPorFiltro']);    
    Route::post('marcaciones-por-personal', [MarcacionController::class, 'marcacionReporte']);
    Route::post('marcaciones-mensual', [MarcacionController::class, 'marcacionMensual']);
    Route::post('marcaciones-mensual-docente', [MarcacionController::class, 'marcacionMensualDocente']);
    Route::post('marco-hoy', [MarcacionController::class, 'marcoHoy']);
});
//PERSONAL
Route::group(['prefix' => 'personal'], function () {
    Route::get('mostrar', [PersonaController::class, 'show']);
    Route::get('mostrar-codigo', [PersonaController::class, 'showByCode']);
    Route::post('actualizar', [PersonaController::class, 'update']);
    Route::post('eliminar', [PersonaController::class, 'destroy']);
    Route::post('guardar', [PersonaController::class, 'store']);
    Route::post('listar', [PersonaController::class, 'listar']);
    Route::post('reporte', [PersonaController::class, 'reporte']);
    Route::get('todos', [PersonaController::class, 'todos']);
    Route::get('cambiar-estado', [PersonaController::class, 'cambiarEstado']);
    Route::post('cambiar-deuda', [PersonaController::class, 'cambiarEstadoDeuda']);    
});
