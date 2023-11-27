<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\FormularioController;
use Illuminate\Support\Facades\Session;
use App\Models\Edificio;
use Carbon\Carbon;
use Carbon\CarbonInterface;



class RecorridoController extends Controller
{
    public function index(Request $request)
    {
        // Verificar si la solicitud HTTP es de tipo POST (se esta enviando un formulario al servidor)
        if (request()->isMethod('post') && request()->has('Asistencia')) {
            $asistencias = request()->input('Asistencia');

            // Realizar consulta en la base de datos para obtener los registros existentes, 
            $registros = DB::table('datos')->select('ID', 'Estado')->get();

            foreach ($registros as $registro) {
                $id = $registro->ID;
                $estadoActual = $registro->Estado;

                // Obtener la asistencia seleccionada para este registro
                $asistencia = isset($asistencias[$id]) ? $asistencias[$id] : "";

                // Actualizar la asistencia solo si se ha seleccionado una opción
                if (!empty($asistencia)) {
                    DB::table('datos')->where('ID', $id)->update(['Estado' => $asistencia]);

                    echo "Asistencia actualizada con éxito.";
                }
            }
        }
     


     $hora = $this->obtenerHoraActual($request); // Formatea la hora como HH:MM:SS
     $diaSemana = $this->obtenerNumeroDiaActual(); // Llama al método para obtener el número del día ajustado
     #error_log($numeroDia);
     #error_log($hora);


#$hora = '13:24:00';
        #$hora = $request->input('hora');
         #error_log($hora);

#$diaSemana = 6;

$registros = DB::table('grupos_horarios AS gh')
    ->select('gh.clave_materia', 'm.nombre_materia', 'gh.hora_inicio', 'gh.hora_fin', 'a.aula', 'a.edificio', 'p.rfc','gh.clave_plan_estudios','gh.periodo','gh.letra_grupo', DB::raw("CONCAT(p.nombre, ' ', p.ap_paterno, ' ', p.ap_materno) as 'Nombre Docente'"))
    ->join('aulas AS a', 'gh.aula', '=', 'a.aula')
    ->join('materias AS m', function ($join) {
        $join->on('gh.clave_materia', '=', 'm.clave_materia')
            ->on('m.clave_plan_estudios', '=', 'gh.clave_plan_estudios');
    })
    ->join('grupos AS g', function ($join) {
        $join->on('g.clave_materia', '=', 'gh.clave_materia')
            ->on('g.clave_plan_estudios', '=', 'gh.clave_plan_estudios')
            ->on('gh.letra_grupo', '=', 'g.letra_grupo');
    })
    ->join('profesores AS p', 'p.rfc', '=', 'g.docente')
    ->where('dia_semana', $diaSemana)
    ->whereTime('gh.hora_inicio', '<=', $hora)
    ->whereTime('gh.hora_fin', '>=', $hora)
    ->get();



        #$registros = DB::table('datos')->select('ID', 'Salon', 'Materia', 'Profesor', 'Horario')->get();
        // Puedes manejarlo aquí
    
        // Paso 3: Consulta de datos
        
        $edificios = $this->obtenerEdificios($request);

        return view('recorrido/pruebascesar', compact('edificios','registros'));   

        


       


    }


    public function obtenerEdificios(Request $peticion){
        $edificios = DB::table('aulas')
        ->select('edificio')
        ->distinct()
        ->get();
        return $edificios;
    }

    public function obtenerProfes(Request $request){
        $edificioId = $request->input('edificios');
        $salonSelecc = $request->input('salones');
        error_log($edificioId);
        $hora = $this->obtenerHoraActual($request); // Formatea la hora como HH:MM:SS
        $diaSemana = $this->obtenerNumeroDiaActual();
        #$hora = $horaActualFormateada->toTimeString(); // Formatea la hora como HH:MM:SS

        if ($edificioId == 0) {
            // Si $edificioId es igual a cero, mostrar todos los registros
            $query  = DB::table('grupos_horarios AS gh')
    ->select('gh.clave_materia', 'm.nombre_materia', 'gh.hora_inicio', 'gh.hora_fin', 'a.aula', 'a.edificio', 'p.rfc','gh.clave_plan_estudios','gh.periodo','gh.letra_grupo', DB::raw("CONCAT(p.nombre, ' ', p.ap_paterno, ' ', p.ap_materno) as 'Nombre Docente'"))
    ->join('aulas AS a', 'gh.aula', '=', 'a.aula')
    ->join('materias AS m', function ($join) {
        $join->on('gh.clave_materia', '=', 'm.clave_materia')
            ->on('m.clave_plan_estudios', '=', 'gh.clave_plan_estudios');
    })
    ->join('grupos AS g', function ($join) {
        $join->on('g.clave_materia', '=', 'gh.clave_materia')
            ->on('g.clave_plan_estudios', '=', 'gh.clave_plan_estudios')
            ->on('gh.letra_grupo', '=', 'g.letra_grupo');
    })
    ->join('profesores AS p', 'p.rfc', '=', 'g.docente')
    ->where('dia_semana', $diaSemana)
    ->whereTime('gh.hora_inicio', '<=', $hora)
    ->whereTime('gh.hora_fin', '>=', $hora)
    ->get();
           
        } else {
            // Si $edificioId no es igual a cero, filtrar por edificio
         
            $query  = DB::table('grupos_horarios AS gh')
            ->select('gh.clave_materia', 'm.nombre_materia', 'gh.hora_inicio', 'gh.hora_fin', 'a.aula', 'a.edificio', 'p.rfc','gh.clave_plan_estudios','gh.periodo','gh.letra_grupo', DB::raw("CONCAT(p.nombre, ' ', p.ap_paterno, ' ', p.ap_materno) as 'Nombre Docente'"))
            ->join('aulas AS a', 'gh.aula', '=', 'a.aula')
            ->join('materias AS m', function ($join) {
                $join->on('gh.clave_materia', '=', 'm.clave_materia')
                    ->on('m.clave_plan_estudios', '=', 'gh.clave_plan_estudios');
            })
            ->join('grupos AS g', function ($join) {
                $join->on('g.clave_materia', '=', 'gh.clave_materia')
                    ->on('g.clave_plan_estudios', '=', 'gh.clave_plan_estudios')
                    ->on('gh.letra_grupo', '=', 'g.letra_grupo');
            })
            ->join('profesores AS p', 'p.rfc', '=', 'g.docente')
            ->where('dia_semana', $diaSemana)
            ->whereTime('gh.hora_inicio', '<=', $hora)
            ->whereTime('gh.hora_fin', '>=', $hora)
            ->where('a.edificio', $edificioId)
            ->get();
        }
        
       
      
    
        // Ejecutar la consulta y obtener los resultados
        #$regis = $query->get();
        return response()->json($query);
    }
   
    
    public function nombrelet(Request $request){

    
         $nombre = $request->input('nombre');
        
                // Realiza una búsqueda en la base de datos para obtener resultados que coincidan con el nombre
        $resultados = DB::table('datos')->where('profesor', 'LIKE', '%' . $nombre . '%')->get();
        
                // Devuelve los resultados como JSON
        return response()->json($resultados);
 }

        
public function obtenerHoraActual()
{
    $horaActual = Carbon::now();
    $formatoHora = $horaActual->format('H:i:s'); // Formato de 24 horas (por ejemplo, "14:30:00")

    return $formatoHora;
}


public function obtenerHoraActual2()
{
    $horaActual = Carbon::now(); // Obtiene la hora actual
    $diaActual = Carbon::now()->format('Y-m-d'); // Obtiene el día actual en el formato "año-mes-día"

    return [
        'horaActual' => $horaActual,
        'diaActual' => $diaActual,
    ];
}





public function obtenerNumeroDiaActual()
{
    Carbon::setLocale('es'); // Establece el idioma en español

    $numeroDia = Carbon::now()->dayOfWeek; // Obtiene el número del día de la semana (0 para domingo, 1 para lunes, etc.)

    // Ajusta el valor para que el domingo sea 1 y continúe en orden
    $numeroDia = ($numeroDia % 7) + 1; // Ajusta el valor para que el domingo sea 1, el lunes 2, martes 3, etc.

    return $numeroDia;
}

   


 public function registrarAsistencia(Request $request)
 {
    $datosJSON = $request->input('datos');

    // Decodifica los datos JSON en un arreglo asociativo
    $datos = json_decode($datosJSON, true);
    $numdatos = count($datos);
    $horaActualFormateada = $this->obtenerHoraActual2();
    $horaActual = $horaActualFormateada['horaActual'];
    $diaNum = $this->obtenerNumeroDiaActual();
    $prefec = 'UAHA830311QH8';
   /* try {
        DB::table('grupos_asistencias')->insert([
            'clave_materia' => $datos[0]['claveMateria'],
            'clave_plan_estudios' => $datos[0]['clavePlanEstudios'],
            'periodo' => $datos[0]['periodo'],
            'letra_grupo' => $datos[0]['letraGrupo'],
            'dia_semana' => $diaNum,
            'fecha_hora' => $horaActual,
            'asistencia' => $datos[0]['asistencia'],
            'observacion' => $datos[0]['observacion'],
            'RFC_prefecto' => $prefec,
        ]);
    } catch (\Exception $e) {
        // Maneja la excepción aquí y registra detalles del error
        error_log($e->getMessage());
    }*/
    
  
    for ($i = 0; $i < $numdatos; $i++) {
       /* $clavemat = $datos[$i]['claveMateria'];
        $clavepla = $datos[$i]['clavePlanEstudios'];
        $perio = $datos[$i]['periodo'];
        $letra = $datos[$i]['letraGrupo'];
        $asist = $datos[$i]['asistencia'];
        $obser = $datos[$i]['observacion'];
        
        
        // Combina los valores de edificio y materia en una sola variable
        $valo = $clavemat. ' - '.$clavepla.' - '.$perio.' - ' .$letra.' - '.$diaNum.' - '.$horaActual.' - '.$asist.' - '.$obser  ;*/
        DB::table('grupos_asistencias')->insert([
            'clave_materia' => $datos[$i]['claveMateria'],
            'clave_plan_estudios' => $datos[$i]['clavePlanEstudios'],
            'periodo' => $datos[$i]['periodo'],
            'letra_grupo' => $datos[$i]['letraGrupo'],
            'dia_semana' => $diaNum,
            'fecha_hora' => $horaActual,
            'asistencia' => $datos[$i]['asistencia'],
            'observacion' => $datos[$i]['observacion'],
            'RFC_prefecto' => $prefec,
        ]);
    
    }
 
 }
 


    public function updateAsistencia(Request $request)
{
    // Valida los datos del formulario
    $request->validate([
        'Asistencia' => 'required|array', // Asegúrate de que Asistencia sea un arreglo
    ]);

    // Obtiene las asistencias enviadas en el formulario
    $asistencias = $request->input('Asistencia');

    // Recorre las asistencias y actualiza la base de datos
    foreach ($asistencias as $id => $asistencia) {
        // Validar que $asistencia sea un valor válido (por ejemplo, 'Asistio' o 'No asistio')
        if (in_array($asistencia, ['Asistio', 'No asistio'])) {
            DB::table('datos')
                ->where('ID', $id)
                ->update(['Estado' => $asistencia]);
        }
    }

    // Redirige de nuevo a la página con un mensaje de éxito
    return redirect('/recorrido/pruebascesar')->with('success', 'Asistencias actualizadas con éxito.');
}
}