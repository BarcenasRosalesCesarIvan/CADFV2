<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\prefectoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecorridoController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TablaController;
use App\Http\Controllers\RegistroController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return view('bienvenida');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/cambiar-contrasena', [App\Http\Controllers\Auth\ChangePasswordController::class, 'showChangePasswordForm'])->name('cambiar-contrasena')->middleware('auth');;
Route::post('/cambiar-contrasena', [App\Http\Controllers\Auth\ChangePasswordController::class, 'changePassword'])->name('cambiar-contrasena.post')->middleware('auth');;


//Route::get('/test', [App\Http\Controllers\HomeController::class, 'test'])->name('test');

//Route::get('/prefectura/edit', [App\Http\Controllers\prefectoController::class, 'crudPrefecto'])->name('crudPrefecto');
//Route::get('/prefectura/asistencia', [App\Http\Controllers\prefectoController::class, 'asistenciaDocente'])->name('asistenciaDocente');
//Route::get('/prefectura/reportes', [App\Http\Controllers\prefectoController::class, 'reportesDocente'])->name('reportesDocente');

Route::group(['middleware' => ['role:jefe|admin']], function () {
    Route::get('/prefectura/edit', [prefectoController::class, 'crudPrefecto'])->name('crudPrefecto');
    Route::get('/prefectura/reportes', [RegistroController::class, 'index'])->name('reportesDocente');//525
    //Ruta para añadir un nuevo prefecto
    Route::get("/anadir-prefecto", [App\Http\Controllers\Auth\RegisterController::class, "createUser"])->name("createUser");
    //Ruta para eliminar un prefecto
    Route::get("/eliminarprefecto-{RFC}", [App\Http\Controllers\Auth\RegisterController::class, "delete"])->name("crud.delete");
    //Ruta para modificar un prefecto
    Route::get("/modificar-prefecto-{RFC}", [App\Http\Controllers\Auth\RegisterController::class, "updatePrefecto"])->name("crud.update");
    //Route::get("/modificar-prefecto-{RFC}", [prefectoController::class, 'updatePrefecto'])->name("crud.update");
    
    //rutas cesar
    Route::get('/recorrido/pruebascesar', [RecorridoController::class, 'index']);

    Route::get('/recorrido/pruebasregis', [RegistroController::class, 'index']);
    
    
    Route::post('/recorrido/pruebas', [RecorridoController::class, 'index'])->name('hora');
    
    
    Route::post('/recorrido/pruebasces', [RecorridoController::class, 'obtenerProfes'])->name('ajax');
    
    Route::post('/recorrido/pruebasregi', [RegistroController::class, 'obtenerRegis'])->name('ajaxre');
    
    
    Route::post('/recorrido/pruebasce', [RecorridoController::class, 'nombrelet'])->name('ajax2');
    Route::post('/recorrido/pruebasre', [RegistroController::class, 'nombrelet'])->name('ajax2r');
    
    
    Route::post('/recorrido/pruebasc', [RecorridoController::class, 'registrarAsistencia'])->name('ajax3');
    
    Route::post('/recorrido/pruebascesar', [RecorridoController::class, 'updateAsistencia']);
    
    
    Route::get('/cargar-salones/{edificioId}', [SalonController::class, 'cargarSalones']);
    
    Route::get('/cargar-profesor/{profesorId}', [ProfesorController::class, 'cargarProfes']);
    
    
    Route::post('/recorrido/pruebasg', [RegistroController::class, 'obtenerfech'])->name('ajax4');
    
    Route::post('/exportar-a-excel', [Tablacontroller::class,'exportarAExcel'])->name('exportar-a-excel');
    
    
});

Route::get('/test', [HomeController::class, 'test'])->name('test');


Route::group(['middleware' => ['role:prefecto|admin']], function () {
    Route::get('/prefectura/asistencia', [RecorridoController::class, 'index'])->name('asistenciaDocente');   
     Route::post('/recorrido/pruebas', [RecorridoController::class, 'index'])->name('hora');
     Route::post('/recorrido/pruebasces', [RecorridoController::class, 'obtenerProfes'])->name('ajax');
     Route::post('/recorrido/pruebasce', [RecorridoController::class, 'nombrelet'])->name('ajax2');
     Route::post('/recorrido/pruebasc', [RecorridoController::class, 'registrarAsistencia'])->name('ajax3');
    
     Route::post('/recorrido/pruebascesar', [RecorridoController::class, 'updateAsistencia']);
    Route::get('/prefectura/asistencia_edificio', [prefectoController::class, 'horarioEdificio'])->name('horarioEdificio');
    Route::post('/guardar-asistencia', [prefectoController::class, 'guardarAsistencia'])->name('guardarAsistencia');
    Route::post('/prefectura/agregar-observacion', [prefectoController::class, 'agregarObservacion'])->name('agregarObservacion');
});

