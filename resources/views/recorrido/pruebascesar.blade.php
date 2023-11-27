@extends('layouts.plantilla') {{-- Asegúrate de que estás extendiendo el diseño correcto si tienes uno --}}
@section('content')


    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-0MEY0YXK6T"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-0MEY0YXK6T');
    </script>



    <meta name="csrf-token" content="{{ csrf_token() }}">


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="wKhjeWmLRYCaifIV13OYiXMbnt97JOjY1igAYKgE">

    <title>CETECH - Sistema de Información Escolar</title>
    <link rel="stylesheet" href="https://cetech.sjuanrio.tecnm.mx/css/app.css">
    <link rel="stylesheet" href="https://cetech.sjuanrio.tecnm.mx/css/autocompleter.css">
    <link rel="stylesheet" href="https://cetech.sjuanrio.tecnm.mx/jqueryui-editable/css/jqueryui-editable.css">
    <link rel="stylesheet" href="https://cetech.sjuanrio.tecnm.mx/css/checkbox_off.css">
    <link rel="stylesheet" href="https://cetech.sjuanrio.tecnm.mx/css/dataTables.bootstrap.min.css">                            

    <!--  estilo institucion -->
    
        <link rel="stylesheet" href="https://cetech.sjuanrio.tecnm.mx/css/css_220034.css">

    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- chosen -->
    <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.css">

</head>


<div class="card-header">
    <h1>Registro de Asistencia Docente</h1>
   
    <p class="mensaje">El día de hoy es: <span id="fechaHoraActual" class="mensaje"></span></p>
   </div>   
   <!-- resources/views/mi_vista.blade.php -->

    

   <!--<body>
   <label for="nombre">Nombre:</label>
    <input type="text" id="textoEnTiempoReal" placeholder="Escribe aquí">
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
-->
<script>
   /* $(document).ready(function () {
        var textoAnterior = '';  // Variable para almacenar el texto anterior

        // Captura el evento de cambio en el cuadro de texto
        $('#textoEnTiempoReal').on('input', function () {
            var textoIngresado = $(this).val();

            // Compara el texto ingresado con el texto anterior
            for (var i = textoAnterior.length; i < textoIngresado.length; i++) {
                console.log(textoIngresado[i]);
            }

            // Actualiza el texto anterior
            textoAnterior = textoIngresado;
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

$.ajax({
    url: '{{ route('ajax2') }}', // Cambia la URL a la que desees enviar la variable
    type: 'POST',
    dataType: 'json',
    headers: {
    'X-CSRF-TOKEN': csrfToken  },
    data: {
          nombre: textoAnterior // Nombre diferente para la segunda variable
     },
    success: function (data) {
        $('#miTabla tbody').empty();

// Recorre los datos y agrégales a la tabla
$.each(data, function (index, item) {
var newRow = '<tr>' +
'<td>' + item.Salon + '</td>' +
'<td>' + item.Materia + '</td>' +
'<td>' + item.Profesor + '</td>' +
'<td><small>' + item.Horario + '</small></td>' +
'<td>' +
'<select class="form-control" name="Asistencia[' + item.ID + ']">' +
'<option value="Asistio">Asistio</option>' +
'<option value="No asistio">No asistio</option>' +
'</select>' +
'</td>' +
'</tr>';

$('#miTabla tbody').append(newRow);
});
        console.log("Datos recibidos de la segunda solicitud AJAX:", data);

    },
    error: function (xhr, status, error) {
        console.log("Error en la segunda solicitud AJAX:");
        console.log(xhr.responseText);
        console.log(status);
        console.log(error);
    }
});
        });
    });*/
</script>



         

   <div class="card-body">
    <a href="https://cetech.sjuanrio.tecnm.mx/home" class="btn btn-danger">
            <i class="fas fa-arrow-left"></i> Regresar
        </a>
        
        
        <a href="https://cetech.sjuanrio.tecnm.mx/estudiantes/71536/carga_academica" class="btn btn-primary" target="_black">Imprimir Tablas</a>

        <hr>

          <!-- JCOMBOBOX PARA FILTRADO-->

        <label for="edificio" style="display: inline-block; margin-right: 10px;">Selecciona un edificio:</label>
        <select id="edificioSelect" style="display: inline-block;">
            <option value= 0></option>
            @foreach($edificios as $edificio)
            <option value="{{ $edificio->edificio }}">{{ $edificio->edificio }}</option>
        @endforeach
        </select>
<!--
        <label for="salon" style="display: inline-block; margin-left: 20px;">Selecciona un Salon:</label>
        <select id="salonSelect" style="display: inline-block;">
            <option value="vacio"></option>
        </select>
    -->
        
      

        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    $(document).ready(function () {
        $('#edificioSelect').on('change', function () {
           var edificioId = $(this).val();
            $('#salonSelect').empty();
            console.log(edificioId);
            if (edificioId) {

                $.ajax({
                    url: '/cargar-salones/' + edificioId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#salonSelect').empty();

                       // Agrega una opción en blanco
                       $('#salonSelect').append('<option value=0></option>');
                        $.each(data, function (index,element) {
                          
                            $('#salonSelect').append('<option value="' + element + '">' + element + '</option>');
                        });
                    
                    
                    },
                    error: function (xhr, status, error) {
        // Hubo un error en la solicitud AJAX. Puedes manejarlo aquí.
        console.log("Error en la solicitud AJAX:");
        console.log(xhr.responseText);
        console.log(status);
        console.log(error);
                    }
                });
            }
            if (edificioId) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ route('ajax') }}', // Cambia la URL a la que desees enviar la variable
                type: 'POST',
                dataType: 'json',
                headers: {
                'X-CSRF-TOKEN': csrfToken  },
                data: {
                      edificios: edificioId // Nombre diferente para la segunda variable
                 },
                success: function (data) {
                    $('#miTabla tbody').empty();

// Recorre los datos y agrégales a la tabla
$.each(data, function (index, item) {
    var newRow = '<tr>' +
                        '<td>' + item.edificio + '</td>' +
                        '<td>' + item.aula + '</td>' +
                        '<td>' + item.clave_materia + '</td>' +
                        '<td>' + item.nombre_materia + '</td>' +
                        '<td>' + item.hora_inicio + '</td>' +
                        '<td>' + item.hora_fin + '</td>' +
                        '<td>' + item.rfc + '</td>' +
                        '<td>' + item['Nombre Docente'] + '</td>' +
                        '<td>' +
                        '<select class="form-control asistencia-select" name="asistencias[' + item.clave_materia + '][' + item.rfc + ']">' +
                            '<option value=""></option>'+
                            '<option value="Asistio">Asistio</option>' +
                            '<option value="No asistio">No asistio</option>' +
                            '<option value="Retardo">Retardo</option>'+
                        '</select>' +
                        '</td>' +
                        '<td>' +
                        '<input type="text" class="form-control campo-observacion" name="observaciones[{{ '+item.clave_materia +'}}][{{ '+item.rfc+'}}]" maxlength="50" value="{{ isset($observaciones['+item.clave_materia+']['+item.rfc+']) ? $observaciones['+item.clave_materia+']['+item.rfc+'] : '' }}">' +
                        '<td hidden>' + item.clave_plan_estudios+'</td>'+
                        '<td hidden>' + item.periodo+'</td>'+
                        '<td hidden>' + item.letra_grupo + '</td>' +

                        '</tr>';
                        

    $('#miTabla tbody').append(newRow);
});

    // Agrega el evento de cambio de color a los nuevos elementos select
    const asistenciaSelects = document.querySelectorAll('.asistencia-select');

    asistenciaSelects.forEach(asistenciaSelect => {
        asistenciaSelect.addEventListener('change', function () {
            if (asistenciaSelect.value === 'Asistio') {
                asistenciaSelect.style.backgroundColor = 'rgba(60, 211, 70, 0.4)'; // Fondo verde con opacidad reducida
                asistenciaSelect.style.color = 'black'; // Letra negra
            } else if (asistenciaSelect.value === 'No asistio') {
                asistenciaSelect.style.backgroundColor = 'rgba(255, 0, 0, 0.4)'; // Fondo rojo con opacidad reducida
                asistenciaSelect.style.color = 'black'; // Letra negra
            }else if (asistenciaSelect.value === 'Retardo') {
                asistenciaSelect.style.backgroundColor = 'rgba(255, 255, 0, 0.5)'; // Fondo amarillo con opacidad reducida
                asistenciaSelect.style.color = 'black'; // Letra negra
            } else {
                asistenciaSelect.style.backgroundColor = 'transparent'; // Fondo transparente
                asistenciaSelect.style.color = 'black'; // Letra negra
            }
        });
    });

    // Resto del código...




     // JavaScript para expandir los campos de observación
                const camposObservacion = document.querySelectorAll('#miTabla tbody .campo-observacion');
            
                camposObservacion.forEach(campo => {
                    campo.addEventListener('click', function () {
                        campo.classList.add('expandido-izquierda');
                    });
            
                    campo.addEventListener('blur', function () {
                        campo.classList.remove('expandido-izquierda');
                    });
                });
          
    
  
            
                    console.log("Datos recibidos de la segunda solicitud AJAX:", data);

                },
                error: function (xhr, status, error) {
                    console.log("Error en la segunda2 solicitud AJAX:");
                    console.log(xhr.responseText);
                    console.log(status);
                    console.log(error);
                }
            });
           }
           
        });
        $('#salonSelect').on('change', function () {
        var salonSelecc = $(this).val();
        console.log("Salon seleccionado:", salonSelecc);
        if (salonSelecc) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

$.ajax({
    url: '{{ route('ajax') }}', // Cambia la URL a la que desees enviar la variable
    type: 'POST',
    dataType: 'json',
    headers: {
        'X-CSRF-TOKEN': csrfToken  },
    data: {
           salones: salonSelecc // Nombre diferente para la segunda variable
                 },
    
    success: function (data) {
        $('#miTabla tbody').empty();

// Recorre los datos y agrégales a la tabla
$.each(data, function (index, item) {
var newRow = '<tr>' +
'<td>' + item.Salon + '</td>' +
'<td>' + item.Materia + '</td>' +
'<td>' + item.Profesor + '</td>' +    
'<td><small>' + item.Horario + '</small></td>' +
'<td>' +
'<select class="form-control" name="Asistencia[' + item.ID + ']">' +
'<option value="Asistio">Asistio</option>' +
'<option value="No asistio">No asistio</option>' +
'</select>' +
'</td>' +
'</tr>';

$('#miTabla tbody').append(newRow);
});
        console.log("Datos recibidos de la segunda solicitud AJAX:", data);

    },
    error: function (xhr, status, error) {
        console.log("Error en la tercera solicitud AJAX:");
        console.log(xhr.responseText);
        console.log(status);
        console.log(error);
    }
});
}
        
        // Puedes realizar acciones adicionales basadas en el valor seleccionado aquí
    });
        
    });

 

</script>
        



    <div class="card-header">
        <!-- declara el metodo post y la url de la vista-->
        <form method="POST" action="{{ url('/recorrido/pruebascesar') }}">
            <!-- se establece el parametro de Laravel para proteger contra CSRF -->
            @csrf
            <table id="miTabla"  class="table table-sm table-bordered table-hover">
                <!-- Encabezados de la tabla -->
                <thead>
                    <tr>
                        <th>Edificio</th>
                        <th>Aula</th>
                        <th>clave materia</th>
                        <th>Materia</th>
                        <th>Hora de Inicio</th>
                        <th>Hora de Fin</th>
                        <th>RFC Docente</th>
                        <th>Nombre Docente</th>
                        <th>Asistencia</th>
                        <th>Observación</th>
                        <th hidden>Clave Plan Estudios</th>
                        <th hidden>Periodo</th> <!--Columnas ocultas -->
                        <th hidden>Letra Grupo</th>  

                    </tr>
                </thead>
                <tbody>
                    @foreach ($registros as $registro)
                        <tr>
                            <td>{{ $registro->edificio }}</td>
                            <td>{{ $registro->aula }}</td>
                            <td>{{ $registro->clave_materia }}</td>
                            <td>{{ $registro->nombre_materia }}</td>
                            <td>{{ $registro->hora_inicio }}</td>
                            <td>{{ $registro->hora_fin }}</td>
                            <td>{{ $registro->rfc }}</td>
                            <td>{{ $registro->{'Nombre Docente'} }}</td>
                            <td>
                                <select class="form-control asistencia-select" name="asistencias[{{ $registro->clave_materia }}][{{ $registro->rfc }}]">
                                    <option></option>
                                    <option value="Asistio" {{ isset($asistencias[$registro->clave_materia][$registro->rfc]) && $asistencias[$registro->clave_materia][$registro->rfc] == 'Asistio' ? 'selected' : '' }}>Asistio</option>
                                    <option value="No asistio" {{ isset($asistencias[$registro->clave_materia][$registro->rfc]) && $asistencias[$registro->clave_materia][$registro->rfc] == 'No asistio' ? 'selected' : '' }}>No asistio</option>
                                    <option value="Retardo" {{ isset($asistencias[$registro->clave_materia][$registro->rfc]) && $asistencias[$registro->clave_materia][$registro->rfc] == 'Retardo' ? 'selected' : '' }}>Retardo</option>

                                </select>
                                
                            </td>
                            <td>
                                <input type="text" class="form-control campo-observacion" name="observaciones[{{ $registro->clave_materia }}][{{ $registro->rfc }}]" maxlength="50" value="{{ isset($observaciones[$registro->clave_materia][$registro->rfc]) ? $observaciones[$registro->clave_materia][$registro->rfc] : '' }}">
                            </td>
                            <td hidden>{{ $registro->clave_plan_estudios }}</td> <!-- Esta columna está siempre oculta -->
                            <td hidden>{{ $registro->periodo }}</td> <!-- Columna oculta para Periodo -->
                            <td hidden>{{ $registro->letra_grupo }}</td> <!-- Columna oculta para Letra Grupo -->

                        </tr>
                    @endforeach
                </tbody>
            </table>

          
            <script>
    document.addEventListener('DOMContentLoaded', function () {
    const asistenciaSelects = document.querySelectorAll('.asistencia-select');

    asistenciaSelects.forEach(asistenciaSelect => {
        asistenciaSelect.addEventListener('change', function () {
            if (asistenciaSelect.value === 'Asistio') {
                asistenciaSelect.style.backgroundColor = 'rgba(60, 211, 70, 0.4)'; // Fondo verde con opacidad reducida
                asistenciaSelect.style.color = 'black'; // Letra negra
            } else if (asistenciaSelect.value === 'No asistio') {
                asistenciaSelect.style.backgroundColor = 'rgba(255, 0, 0, 0.4)'; // Fondo rojo con opacidad reducida
                asistenciaSelect.style.color = 'black'; // Letra negra
            
            }else if (asistenciaSelect.value === 'Retardo') {
                asistenciaSelect.style.backgroundColor = 'rgba(255, 255, 0, 0.5)'; // Fondo amarillo con opacidad reducida
                asistenciaSelect.style.color = 'black'; // Letra negra
            }else {
                asistenciaSelect.style.backgroundColor = 'transparent'; // Fondo transparente
                asistenciaSelect.style.color = 'black'; // Letra negra
            }
        });
    });
});


            </script>
            
              
          

            <script>
                // JavaScript para expandir los campos de observación
                const camposObservacion = document.querySelectorAll('.campo-observacion');
            
                camposObservacion.forEach(campo => {
                    campo.addEventListener('click', function () {
                        campo.classList.add('expandido-izquierda');
                    });
            
                    campo.addEventListener('blur', function () {
                        campo.classList.remove('expandido-izquierda');
                    });
                });
            </script>
            

<!-- ... (más código HTML) ... -->
</body>
</html>

<style>
.campo-observacion.expandido-izquierda {
    transform: translateX(-50%);
    width: 200%; /* Ancho aumentado para que se expanda hacia la izquierda */
    left: 0; /* Alinea el campo a la izquierda */
    height: 100px; /* Ajusta la altura según tus necesidades */
    resize: none; /* Evita que se pueda redimensionar el campo */
    overflow: auto; /* Habilita la barra de desplazamiento si es necesario */
}

</style> 
<style>
    #asistenciaSelect {
        background-color: transparent; /* Establece un fondo transparente por defecto */
    }

    #asistenciaSelect.green {
    background-color: rgba(161, 214, 196, 0.05); /* Establece un fondo verde muy transparente para "Asistió" */
    color: white;
}

#asistenciaSelect.red {
    background-color: rgba(255, 0, 0, 0.05); /* Establece un fondo rojo muy transparente para "No Asistió" */
    color: white;
}

</style>
            
                        
           

            <!-- Contenedor para el botón -->
            <div>
                <span class="btn btn-success">Generar Reporte Excel</span>
                <button id="enviarDatos" class="btn btn-primary" type="button">Guardar Asistencia</button>
            </div>
            
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            
            <script>
                $(document).ready(function () {
                    // Función para enviar datos al servidor
                    function enviarDatosAlServidor(datos) {
                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
            
                        // Realiza una solicitud AJAX para enviar los datos al servidor
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('ajax3') }}',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            data: {
                                datos: JSON.stringify(datos)
                            },
                            success: function (respuesta) {
                                console.log(respuesta);
                                // Elimina los datos almacenados localmente después de la sincronización
                                localStorage.removeItem('datos_pendientes');
                            },
                            error: function (error) {
                                localStorage.setItem('datos_pendientes', JSON.stringify(datos));

                                console.log("No se gurdaron");
                                console.log(error);
                            }
                        });
                    }
            
                    // Función para verificar la conectividad y enviar datos pendientes
                    function verificarConectividadYEnviar() {
                        if (navigator.onLine) {
                            // Hay conexión a Internet, intenta enviar datos pendientes
                            var datosPendientesGuardados = localStorage.getItem('datos_pendientes');
                            if (datosPendientesGuardados) {
                                var datosPendientes = JSON.parse(datosPendientesGuardados);
                                console.log(datosPendientes);

                                enviarDatosAlServidor(datosPendientes);
                            }
                        }
                    }
            
                    // Escucha el evento "online" para detectar la conexión a Internet
                    window.addEventListener('online', function () {
                        console.log('Conexión a Internet disponible'); 

                        verificarConectividadYEnviar();
                    });
            
            
                    // Escucha el clic en el botón "Guardar Asistencia"
                    $('#enviarDatos').click(function () {
                        var datos = []; // Un arreglo para almacenar los datos de la tabla
            
                        // Recorre cada fila de la tabla excepto la primera (encabezados)
                        $('#miTabla tbody tr').each(function () {
                            var fila = $(this);
                            var claveMateria = fila.find('td:eq(2)').text();
                            var asistencia = fila.find('select').val();
                            var observacion = fila.find('input').val();
                            var clavePlanEstudios = fila.find('td:hidden:eq(0)').text();
                            var periodo = fila.find('td:hidden:eq(1)').text();
                            var letraGrupo = fila.find('td:hidden:eq(2)').text();
            
                            // Agrega los datos de la fila al arreglo
                            datos.push({
                                claveMateria: claveMateria,
                                asistencia: asistencia,
                                observacion: observacion,
                                clavePlanEstudios: clavePlanEstudios,
                                periodo: periodo,
                                letraGrupo: letraGrupo,
                            });
                        });
            
                        // Intenta enviar los datos al servidor
                        enviarDatosAlServidor(datos);
                    });
                });
            </script>
            
            
            
            
         
        </form>
        
    </div>
@endsection







<script>
    
    // JavaScript para mostrar la fecha y la hora actual
    const fechaHoy = new Date();
    const opcionesFecha = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const fechaFormateada = fechaHoy.toLocaleDateString('es-ES', opcionesFecha);

    const opcionesHora = { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: false };
    const horaFormateada = fechaHoy.toLocaleTimeString('es-ES', opcionesHora);

    // Insertar la fecha y la hora actual en el elemento HTML
    const fechaHoraActualElemento = document.getElementById('fechaHoraActual');
    fechaHoraActualElemento.textContent = ${fechaFormateada} ${horaFormateada};
</script>


<script>


 
// Función para actualizar la hora actual cada segundo
function actualizarHora() {
    const fechaHoy = new Date();
    const opcionesHora = { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: false };
    const horaFormateada = fechaHoy.toLocaleTimeString('es-ES', opcionesHora);
    const fechaHoraActualElemento = document.getElementById('fechaHoraActual');
    fechaHoraActualElemento.textContent = ${fechaFormateada};
}

// Llamar a la función actualizarHora() para mostrar la hora actual inicialmente
actualizarHora();

// Actualizar la hora cada segundo
setInterval(actualizarHora, 1000);
</script>