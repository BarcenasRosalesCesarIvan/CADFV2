<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\MiTablaExport;
use Maatwebsite\Excel\Facades\Excel;

class TablaController extends Controller
{
   
    
    public function exportarTabla()
    {
  
    }


    public function exportarAExcel(Request $request)
    {
        // Obtén los datos de la solicitud
        $datos = json_decode($request->input('data'), true);
        
        // Formatea los datos en un arreglo para Maatwebsite/Excel
        $arregloDatos = [];

        // Agrega el resto de los datos
        foreach ($datos as $registro) {
            $arregloDatos[] = [
                $registro[0],
                $registro[1],
                $registro[2],
                $registro[3],
                $registro[4],
                $registro[5],
                $registro[6],
                $registro[7],
                $registro[8],
            ];
        }

        // Configura el nombre del archivo de Excel
        $nombreArchivo = 'reportes_semanal.xlsx';

        // Genera y descarga el archivo de Excel utilizando la clase de exportación
        return Excel::download(new MiTablaExport($arregloDatos), $nombreArchivo);
    }
}