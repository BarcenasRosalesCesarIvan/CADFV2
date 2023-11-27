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
    <h1>Reportes de Asistencia Docente</h1>
   
    <p class="mensaje">El día de hoy es: <span id="fechaHoraActual" class="mensaje"></span></p>
   </div>   
   <!-- resources/views/mi_vista.blade.php -->

    




         

   <div class="card-body">
    <a href="https://cetech.sjuanrio.tecnm.mx/home" class="btn btn-danger">
            <i class="fas fa-arrow-left"></i> Regresar
        </a>
        
        
        <a href="https://cetech.sjuanrio.tecnm.mx/estudiantes/71536/carga_academica" class="btn btn-primary" target="_black">Imprimir Tablas</a>
        <body>
            <label for="nombre">Buscar:</label>
             <input type="text" id="textoEnTiempoReal" placeholder="Escribe el nombre">
         </body>
         <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
         
         <script>
             $(document).ready(function () {
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
             url: '{{ route('ajax2r') }}', // Cambia la URL a la que desees enviar la variable
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
                        '<td>' + item.dia_semana + '</td>' +
                        '<td>' + item.nombre_materia + '</td>' +
                        '<td>' + item.letra_grupo + '</td>' +
                        '<td>' + item.num_inscritos + '</td>' +
                        '<td>' + item.aula  + '</td>' +
                        '<td>' + item.clave_plan_estudios  + '</td>' +
                        '<td>' + item.fecha_hora + '</td>' +
                        '<td>' + item.asistencia + '</td>' +
                        '<td>' + item.observacion + '</td>' 

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
             });
         </script>
         
        <hr>

          <!-- JCOMBOBOX PARA FILTRADO-->
        <label for="semana" style="display: inline-block; margin-left: 20px;">Selecciona una Semana:</label>
        <select id="semanaSelect" style="display: inline-block;">
            <option value=0></option>
            @foreach($fechas as $fecha)
            <option value="{{ $fecha->inicio_semana }} - {{ $fecha->fin_semana }}">{{ $fecha->inicio_semana }} - {{ $fecha->fin_semana }}</option>
            @endforeach
        </select>

        <label for="area" style="display: inline-block; margin-right: 10px;">Selecciona una area:</label>
        <select id="areaSelect" style="display: inline-block;">
            <option value= 0></option>
            @foreach($areas as $area)
            <option value="{{ $area->descripcion_area }}">{{ $area->descripcion_area }}</option>
        @endforeach
        </select>

        <label for="profesor" style="display: inline-block; margin-left: 20px;">Selecciona un profesor:</label>
        <select id="profesorSelect" style="display: inline-block;">
            <option value="vacio"></option>
        </select>
       
        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script> 
            $(document).ready(function () {
                $('#semanaSelect').on('change', function () {
                    var semanqId = $(this).val();
                    console.log(semanqId);
                    if (semanqId){   
                        var csrfToken = $('meta[name="csrf-token"]').attr('content');
                        var data = {
                data: semanqId
            };
                         $.ajax({
    url: '{{ route('ajax4') }}', // Cambia la URL a la que desees enviar la variable
    type: 'POST',
    dataType: 'json',
    headers: {
        'X-CSRF-TOKEN': csrfToken  },
    data: data, // Utiliza el objeto 'datos' que contiene ambos valores
    
    success: function (data) {
        console.log(data)

 $('#miTabla tbody').empty();

// Recorre los datos y agrégales a la tabla
$.each(data, function (index, item) {
    var newRow = '<tr>' +
                        '<td>' + item.dia_semana + '</td>' +
                        '<td>' + item.nombre_materia + '</td>' +
                        '<td>' + item.letra_grupo + '</td>' +
                        '<td>' + item.num_inscritos + '</td>' +
                        '<td>' + item.aula  + '</td>' +
                        '<td>' + item.clave_plan_estudios  + '</td>' +
                        '<td>' + item.fecha_hora + '</td>' +
                        '<td>' + item.asistencia + '</td>' +
                        '<td>' + item.observacion + '</td>' 

                        '</tr>';
                        

    $('#miTabla tbody').append(newRow);
});
                        },
                        error: function (error) {
                            // Maneja los errores de la solicitud aquí
                            console.error('Error: ' + error);
                        }
                    });}
                    // Aquí puedes realizar una solicitud AJAX para enviar la variable semanqId
 
                });
            });
        </script>
        
    
         
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
           
<script>
var areasId;
var semanqId;
    $(document).ready(function () {
        $('#semanaSelect').on('change', function () {
            semanqId = $(this).val();
        });
        $('#areaSelect').on('change', function () {
           areasId = $(this).val();
            $('#profesorSelect').empty();
            console.log(areasId,semanqId);
            if (areasId) {
                var dato2 = {
                areas: areasId,
                seman: semanqId
            };
                $.ajax({
                    url: '/cargar-profesor/' + areasId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#profesorSelect').empty();
              
                       // Agrega una opción en blanco
                       $('#profesorSelect').append('<option value=0></option>');
                       $.each(data, function (index, element) {
            var nombreCompleto = element.nombre + ' ' + element.ap_paterno + ' ' + element.ap_materno;
            $('#profesorSelect').append('<option value="' + nombreCompleto + '">' + nombreCompleto + '</option>');
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

            if (areasId) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '{{ route('ajaxre') }}', // Cambia la URL a la que desees enviar la variable
                type: 'POST',
                dataType: 'json',

                headers: {
                'X-CSRF-TOKEN': csrfToken  },
                data:dato2, // Nombre diferente para la segunda variable,
                success: function (data) {

                    $('#miTabla tbody').empty();

// Recorre los datos y agrégales a la tabla
$.each(data, function (index, item) {
    var newRow = '<tr>' +
                        '<td>' + item.dia_semana + '</td>' +
                        '<td>' + item.nombre_materia + '</td>' +
                        '<td>' + item.letra_grupo + '</td>' +
                        '<td>' + item.num_inscritos + '</td>' +
                        '<td>' + item.aula  + '</td>' +
                        '<td>' + item.clave_plan_estudios  + '</td>' +
                        '<td>' + item.fecha_hora + '</td>' +
                        '<td>' + item.asistencia + '</td>' +
                        '<td>' + item.observacion + '</td>' 

                        '</tr>';
                        

    $('#miTabla tbody').append(newRow);
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
        $('#profesorSelect').on('change', function () {
        var profeSelecc = $(this).val();
        console.log("Salon seleccionado:", profeSelecc);
        if (profeSelecc) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        console.log(areasId);
        var datos = {
            profes: profeSelecc,
            areas: areasId // Agrega 'areasId' a los datos
        };

$.ajax({
    url: '{{ route('ajaxre') }}', // Cambia la URL a la que desees enviar la variable
    type: 'POST',
    dataType: 'json',
    headers: {
        'X-CSRF-TOKEN': csrfToken  },
    data: datos, // Utiliza el objeto 'datos' que contiene ambos valores
    
    success: function (data) {
    $('#miTabla tbody').empty();

    // Recorre los datos y agrégales a la tabla
    $.each(data, function (index, item) {
        var newRow = '<tr>' +
            '<td>' + item.dia_semana + '</td>' +
            '<td>' + item.nombre_materia + '</td>' +
            '<td>' + item.letra_grupo + '</td>' +
            '<td>' + item.num_inscritos + '</td>' +
            '<td>' + item.aula  + '</td>' +
            '<td>' + item.clave_plan_estudios  + '</td>' +
            '<td>' + item.fecha_hora + '</td>' +
            '<td>' + item.asistencia + '</td>' +
            '<td>' + item.observacion + '</td>' +
            '</tr>';

        $('#miTabla tbody').append(newRow);
    });

    // Realiza otra solicitud AJAX para guardar en Exce
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
    <form method="POST" action="{{ route('exportar-a-excel') }}" id="exportarForm">
        @csrf
        <table id="miTabla" class="table table-sm table-bordered table-hover">
            <thead>
                <tr>
                    <th>Dia</th>
                    <th>Nombre de Asignatura</th>
                    <th>Grupo</th>
                    <th>Alumnos</th>
                    <th>Aula</th>
                    <th>Plan de Estudios</th>
                    <th>Hora</th>
                    <th>Asistencia</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($registros as $registro)
                    <tr>
                        <td>{{ $registro->dia_semana }}</td>
                        <td>{{ $registro->nombre_materia }}</td>
                        <td>{{ $registro->letra_grupo }}</td>
                        <td>{{ $registro->num_inscritos }}</td>
                        <td>{{ $registro->aula }}</td>
                        <td>{{ $registro->clave_plan_estudios }}</td>
                        <td>{{ $registro->fecha_hora }}</td>
                        <td>{{ $registro->asistencia }}</td>
                        <td>{{ $registro->observacion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div>
            <!-- Agrega un botón para exportar a Excel -->
            <button type="button" class="btn btn-success" onclick="exportarExcel()">Exportar a Excel</button>
        </div>
    </form>
</div>

@endsection


<script>
    function exportarExcel() {
    // Obtén los datos actuales de la tabla
    var tableData = [];
    $('#miTabla tbody tr').each(function(index, row) {
        var rowData = [];
        $(row).find('td').each(function(index, col) {
            rowData.push($(col).text());
        });
        tableData.push(rowData);
    });

    // Agrega los datos como un campo oculto al formulario
    $('<input>').attr({
        type: 'hidden',
        name: 'data',
        value: JSON.stringify(tableData)
    }).appendTo('#exportarForm');

    // Envía el formulario para guardar en Excel
    $('#exportarForm').submit();
}
</script>




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