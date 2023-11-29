<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProfesorController extends Controller
{
    public function cargarProfes($areasId)
{
    $profe =  DB::table('organigrama')
    ->select('profesores.nombre', 'profesores.ap_paterno', 'profesores.ap_materno')
    ->join('materias', 'materias.clave_area', '=', 'organigrama.clave_area')
    ->join('profesores', 'profesores.clave_area', '=', 'materias.clave_area')
    ->where('organigrama.descripcion_area', $areasId)
    ->distinct() // Para seleccionar valores distintos
    ->orderBy('profesores.nombre') // Ordenar por el nombre del profesor 
    ->get();
    
   

    return response()->json($profe);
}


}

?>