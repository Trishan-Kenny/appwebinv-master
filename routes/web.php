<?php
//TIndex

use App\Http\Controllers\AreaController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\BienController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\DependenciaController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\OficinaController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\SituacionController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UsuarioTOficinaController;
use App\Http\Middleware\GenericMiddleware;
use Illuminate\Support\Facades\Route;



Route::get('/', [UsuarioController::class, 'actionLogIn']);

//TGeneral
Route::get('general/indexadmin', [GeneralController::class, 'actionIndexAdmin']);
Route::get('general/databackup', [GeneralController::class, 'actionDataBackup']);

//TConfiguracion
Route::match(['get', 'post'], 'configuracion/insertareditar', [ConfiguracionController::class, 'actionInsertarEditar']);

//TUsuario
Route::match(['get', 'post'], 'usuario/insertar', [UsuarioController::class, 'actionInsertar']);
Route::get('usuario/graciasregistro', [UsuarioController::class, 'actionGraciasRegistro']);
Route::match(['get', 'post'], 'usuario/login', [UsuarioController::class, 'actionLogIn']);
Route::get('usuario/logout', [UsuarioController::class, 'actionLogOut']);
Route::get('usuario/ver', [UsuarioController::class, 'actionVer']);
Route::post('usuario/editar', [UsuarioController::class, 'actionEditar']);
Route::post('usuario/cambiarcontrasenia', [UsuarioController::class, 'actionCambiarContrasenia']);

//TOficina
Route::match(['get', 'post'], 'oficina/insertar', [OficinaController::class, 'actionInsertar']);
Route::get('oficina/ver', [OficinaController::class, 'actionVer']);
Route::post('oficina/editar', [OficinaController::class, 'actionEditar']);

//TUsuarioTOficina
Route::post('usuariotoficina/gestionar', [UsuarioTOficinaController::class, 'actionGestionar']);

//TDistrito
Route::post('distrito/jsonporcodigoprovincia', [DistritoController::class, 'actionJsonPorCodigoProvincia']);

//TLocal
Route::match(['get', 'post'], 'local/insertar', [LocalController::class, 'actionInsertar']);
Route::get('local/ver', [LocalController::class, 'actionVer']);
Route::post('local/editar', [LocalController::class, 'actionEditar']);
Route::post('local/jsonporcodigodistrito', [LocalController::class, 'actionJsonPorCodigoDistrito']);

//TDependencia
Route::match(['get', 'post'], 'dependencia/insertar', [DependenciaController::class, 'actionInsertar']);
Route::get('dependencia/ver', [DependenciaController::class, 'actionVer']);
Route::post('dependencia/editar', [DependenciaController::class, 'actionEditar']);
Route::post('dependencia/jsonporcodigolocal', [DependenciaController::class, 'actionJsonPorCodigoLocal']);

//TArea
Route::match(['get', 'post'], 'area/insertar', [AreaController::class, 'actionInsertar']);
Route::get('area/ver', [AreaController::class, 'actionVer']);
Route::post('area/editar', [AreaController::class, 'actionEditar']);

//TCargo
Route::match(['get', 'post'], 'cargo/insertar', [CargoController::class, 'actionInsertar']);
Route::get('cargo/ver', [CargoController::class, 'actionVer']);
Route::post('cargo/editar', [CargoController::class, 'actionEditar']);

//TSituacion
Route::match(['get', 'post'], 'situacion/insertar', [SituacionController::class, 'actionInsertar']);
Route::get('situacion/ver', [SituacionController::class, 'actionVer']);
Route::post('situacion/editar', [SituacionController::class, 'actionEditar']);

//TPersonal
Route::match(['get', 'post'], 'personal/insertar', [PersonalController::class, 'actionInsertar']);
Route::get('personal/ver/{paginaActual}', [PersonalController::class, 'actionVer']);
Route::post('personal/editar', [PersonalController::class, 'actionEditar']);
Route::post('personal/jsonpordni', [PersonalController::class, 'actionJsonPorDni']);
Route::post('personal/verbienesasignados', [PersonalController::class, 'actionVerBienesAsignados']);
Route::get('personal/disposicionbienpdf/{codigoPersonal}', [PersonalController::class, 'actionDisposicionBienPdf']);

//TBien
Route::match(['get', 'post'], 'bien/insertar', [BienController::class, 'actionInsertar']);
Route::get('bien/ver/{paginaActual}', [BienController::class, 'actionVer']);
Route::post('bien/editar', [BienController::class, 'actionEditar']);
Route::post('bien/jsonparaasignacion', [BienController::class, 'actionJsonParaAsignacion']);

//TAsignacion
Route::match(['get', 'post'], 'asignacion/insertar', [AsignacionController::class, 'actionInsertar']);
Route::get('asignacion/ver/{paginaActual}', [AsignacionController::class, 'actionVer']);
Route::get('asignacion/hojaentregapdf/{codigoAsignacion}', [AsignacionController::class, 'actionHojaEntregaPdf']);
