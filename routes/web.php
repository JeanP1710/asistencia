<?php

use App\Http\Controllers\FichaSocioEconomicoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('app');
});
Route::post('/login',[LoginController::class,'login']);

Route::post('/login-alumno',[FichaSocioEconomicoController::class,'login']);
Route::post('/logout-alumno',[FichaSocioEconomicoController::class,'logout']);
Route::group(['middleware' => ['auth:sanctum']],function(){
    Route::post('/logout',[LoginController::class,'logout']);
    Route::get('/usuario-session-data',[UserController::class,'mostrarDatoUsuario']);   
});
Route::get('/ipc',function (){
    return view('foro');
});
require __DIR__."/entidades.php";
Route::get('/{path}',function(){   return view('app'); })->where('path','.*');