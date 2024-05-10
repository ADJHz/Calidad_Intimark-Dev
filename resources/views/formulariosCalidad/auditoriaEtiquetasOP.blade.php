@extends('layouts.app', ['activePage' => 'EtiquetasOP', 'titlePage' => __('Etiquetas OP')])
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">{{ __('Auditoria Etiquetas OP.') }}</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            Fecha: {{ now()->format('d ') . $mesesEnEspanol[now()->format('n') - 1] . now()->format(' Y') }}
                        </div>
                    </div>
                </div>
                <br>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-header card-header-primary text-center">
                                <h4 class="card-title mb-3">{{ __('Informacion General.') }}</h4>
                            </div>
                            <br>
                        </div>
                        <div class="col-md-4">
                            <label for="ordenSelect">Selecciona No/Orden:</label>
                            <select class="form-control" id="ordenSelect" name="ordenSelect" required>
                                <!-- Las opciones se cargarán dinámicamente aquí -->
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-success" id="Buscar">
                                Buscar
                            </button>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="card col-md-12" style="width: auto;">
                    <div class="card-header card-header-primary">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="card-title" style="font-size: 24px;">{{ __('Auditoría.') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div id="accordion" style="margin-top: 1px;">
                        <!-- Los acordeones se generarán dinámicamente aquí -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card.border-primary {
            border-color: rgb(170, 42, 176) !important;
        }

        .card-header.bg-primary {
            background-color: rgb(170, 42, 176) !important;
        }

        .rechazado {
            background-color: #d91f1f;
            /* Fondo rojo */
            color: #fff;
            /* Texto blanco */
        }

        .rechazado td {
            border: 1px solid #fff;
            /* Borde blanco */
        }
    </style>

    <script>
      $(document).ready(function() {
    // Inicializar Select2 para la orden
    $('#ordenSelect').select2({
        placeholder: 'Seleccione una orden',
        allowClear: true
    });

    var currentPage = 1; // Página actual de resultados

        $.ajax({
            url: '/NoOrdenesOP',
            type: 'GET',
            dataType: 'json',
            data: {

            },
            success: function(data) {
                // Agregamos las nuevas opciones desde la respuesta del servidor
                $.each(data.data, function(index, value) {
                    // Agregar las opciones al select
                    $('#ordenSelect').append($('<option>', {
                        text: value.op || value.cpo || value.salesid
                    }));
                });
            },
            error: function(error) {
                console.error('Error al cargar opciones de ordenes: ', error);
            }
        });
            // Manejar clic en el botón de búsqueda
            $('#Buscar').click(function() {
                var orden = $('#ordenSelect').val();
                if (orden) {
                    // Realizar la solicitud AJAX para buscar estilos
                    $.ajax({
                        url: '/buscarEstilosOP',
                        type: 'GET',
                        data: {
                            orden: orden
                        },
                        dataType: 'json',
                        success: function(data) {
                            // Limpiar los acordeones existentes
                            $('#accordion').empty();
                            // Generar acordeones para cada estilo encontrado
                            if (data && data.estilo) {
                                $.each(data.estilo, function(key, value) {
                                    var accordion =
                                        '<div class="card border-primary mb-3">';
                                    accordion +=
                                        '<div class="card-header bg-primary" id="heading' +
                                        key + '">';
                                    accordion += '<h2 class="mb-0">';
                                    accordion +=
                                        '<button class="btn btn-link btn-block text-white" data-toggle="collapse" data-target="#collapse' +
                                        key +
                                        '" aria-expanded="true" aria-controls="collapse' +
                                        key + '">';
                                    accordion += '<span style="font-size: 20px;">' +
                                        'Estilo: ' + (value.estilo || 'Sin estilo') +
                                        '</span>'; // Manejo de caso donde value.estilo es undefined
                                    accordion +=
                                        '<span style="font-size: 18px;" id="status_' +
                                        key +
                                        '">' +
                                        'Status: ' +
                                        (data.statusOP && data.statusOP[key] ? data
                                            .statusOP[
                                                key] : 'Sin estado') +
                                        // Manejo de caso donde data.status no está definido o data.status[key] es undefined
                                        '</span>';
                                    accordion += '</button>';
                                    accordion += '</h2>';
                                    accordion += '</div>';
                                    accordion += '<div id="collapse' + key +
                                        '" class="collapse" aria-labelledby="heading' +
                                        key + '" data-parent="#accordion">';
                                    accordion += '<div class="card-body">';
                                    // Contenido del acordeon
                                    accordion += '<div class="tab-pane" id="messages">';
                                    accordion +=
                                        '<div class="card-body table-responsive">';
                                    accordion += '<table class="table" id="miTabla">';
                                    accordion += '<thead class="text-primary">';
                                    accordion += '<tr>';
                                    accordion +=
                                        '<th style="text-align: left; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;">#</th>';
                                    accordion +=
                                        '<th style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;">No/Orden</th>';
                                    accordion +=
                                        '<th style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;">Estilos</th>';
                                    accordion +=
                                        '<th style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;">Color</th>';
                                    accordion +=
                                        '<th style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;">Talla</th>';
                                    accordion +=
                                        '<th style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;">Cantidad</th>';
                                    accordion +=
                                        '<th style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;">Tamaño Muestra</th>';
                                    accordion +=
                                        '<th style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;">Defectos</th>';
                                    accordion +=
                                        '<th style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: 1%;">Tipo Defectos</th>';
                                    accordion +=
                                        '<th  style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;">Acciones</th>';
                                    accordion +=
                                        '<th  style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%; display: none;">id</th>';

                                    accordion += '</tr>';
                                    accordion += '</thead>';
                                    accordion += '<tbody>';
                                    accordion += '</tbody>';
                                    accordion += '<tfoot>';
                                    accordion += '<tr>';
                                    accordion += '<td>';
                                    accordion +=
                                        '<button type="button" class="btn btn-success" id="Saved">';
                                    accordion += '<span>Guardar</span>';
                                    accordion += '</button>';
                                    accordion += '</td>';
                                    accordion += '</tr>';
                                    accordion += '</tfoot>';
                                    accordion += '</table>';
                                    accordion += '</div>';
                                    accordion += '</div>';
                                    accordion += '</div>';
                                    accordion += '</div>';
                                    accordion += '</div>';
                                    $('#accordion').append(accordion);
                                });
                            } else {
                                console.error(
                                    'No se encontraron estilos en los datos proporcionados.'
                                );
                            }


                        },
                        error: function(error) {
                            console.error('Error al buscar estilos: ', error);
                        }
                    });
                } else {
                    alert('Por favor, seleccione una orden.');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Evento delegado para el clic en elementos .dropdown-item dentro de #accordion
            $('#accordion').on('click', '.dropdown-item', function() {
                var selectedOption = $(this).text();
                // Encontrar el botón de alternancia más cercano (dropdown-toggle) dentro del mismo grupo (dropdown)
                var dropdownToggle = $(this).closest('.dropup').find('.dropdown-toggle');
                dropdownToggle.text(selectedOption);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Controlador para el evento de clic en cualquier acordeón
            $('#accordion').on('click', '.card-header', function() {
                var ordenSeleccionada = $('#ordenSelect').val();
                var estilo = $(this).find('span:first').text().split(':')[1].trim();
                $.ajax({
                    url: '/buscarDatosAuditoriaPorEstiloOP',
                    type: 'GET',
                    data: {
                        estilo: estilo,
                        orden: ordenSeleccionada
                    },
                    dataType: 'json',
                    success: function(data) {

                        // Limpiar tabla antes de agregar resultados
                        $('#miTabla tbody').empty();
                        // Mostrar resultados en la tabla
                        $.each(data, function(index, item) {
                            // Obtener la columna adecuada (op, cpo, o salesid) basada en el nombre de la columna
                            // Seleccionar la columna adecuada basada en la orden seleccionada
                            var columnaOrden = ordenSeleccionada.substring(0, 2) ===
                                'OP' ? item.op : (ordenSeleccionada.substring(0, 2) ===
                                    'OV' ? item.salesid : item.cpo);


                            // Formatear la cantidad
                            var cantidadFormateada = item.qty;
                            if (typeof cantidadFormateada === 'string') {
                                var puntoIndex = cantidadFormateada.indexOf('.');
                                if (puntoIndex !== -1) {
                                    var parteDecimal = cantidadFormateada.substring(
                                        puntoIndex + 1);
                                    if (parteDecimal.length > 2) {
                                        parteDecimal = parteDecimal.substring(0, 2);
                                    }
                                    cantidadFormateada = cantidadFormateada.substring(0,
                                        puntoIndex + 1) + parteDecimal;
                                }
                            }
                            // Verificar si el tamaño de muestra está en el rango de 2 a 20
                            var tamañoMuestra = parseInt(item.tamaño_muestra);
                            var inputHTML =
                                '<input type="number" class="form-control cantidadInput" id="cantidadInput_' +
                                index + '_acordeon_' + estilo + '" value="0">';
                            if (tamañoMuestra == 32 || tamañoMuestra == 50 ||
                                tamañoMuestra == 80 || tamañoMuestra == 125 ||
                                tamañoMuestra == 200 || tamañoMuestra == 315 ||
                                tamañoMuestra == 500 || tamañoMuestra == 800 ||
                                tamañoMuestra == 2000) {
                                inputHTML =
                                    '<td style="text-align: center;"><input type="number" class="form-control cantidadInput" id="cantidadInput_' +
                                    index + '_acordeon_' + estilo + '" value="0"></td>';
                            }
                            // Agregar fila a la tabla
                            var fila = '<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td style="text-align: center;">' + columnaOrden +
                                '</td>' +
                                '<td style="text-align: center;">' + (item.estilo ? item
                                    .estilo : '') + '</td>' +
                                '<td style="text-align: center;">' + (item
                                    .inventcolorid ? item.inventcolorid : 'N/A') +
                                '</td>' +
                                '<td style="text-align: center;">' + (item.sizename ?
                                    item.sizename : 'N/A') + '</td>' +
                                '<td style="text-align: center;">' + (
                                    cantidadFormateada ? cantidadFormateada : 'N/A') +
                                '</td>' +
                                '<td style="text-align: center;"><span class="tamañoMuestra">' +
                                (item.tamaño_muestra ? item.tamaño_muestra : 'N/A') +
                                '</span></td>' +
                                '<td style="text-align: center; position: relative;">' +
                                '<input type="number" class="form-control cantidadInput" id="cantidadInput_' +
                                index + '_acordeon_' + estilo + '" value="0">' +
                                '</td>' +
                                '<td class="select-container" style="text-align: center;">' +
                                (item.Tipo_Defectos ?
                                    '<select class="form-control" id="tipoDefectos_' +
                                    index + '">' +
                                    '<option value="' + item.Tipo_Defectos + '">' + item
                                    .Tipo_Defectos + '</option>' +
                                    '</select>' :
                                    '<select class="form-control" id="tipoDefectos_' +
                                    index + '"></select>') +
                                '</td>' +
                                '<td>' +
                                '<div class="dropup-center dropup">' +
                                '<button id="dropdownToggle_' + index + '_acordeon_' +
                                estilo +
                                '" class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">' +
                                'Opciones' +
                                '</button>' +
                                '<ul class="dropdown-menu" aria-labelledby="dropdownToggle_' +
                                index + '_acordeon_' + estilo + '">' +
                                '<li><a class="dropdown-item text-success" value="Aprobado" data-row-id="' +
                                item.id + '">Aprobado</a></li>' +
                                '<li><a class="dropdown-item text-warning" value="Aprobado Condicionalmente" data-row-id="' +
                                item.id + '">Aprobado Condicionalmente</a></li>' +
                                '<li><a class="dropdown-item text-danger" value="Rechazado" data-row-id="' +
                                item.id + '">Rechazado</a></li>' +
                                '</ul>' +
                                '</div>' +
                                '</td>' +
                                '<td style="display: none;">' + (item.id ? item.id :
                                    'N/A') + '</td>' +
                                '</tr>';

                            $('#miTabla tbody').append(fila);
                        });
                        // Cargar opciones del select mediante AJAX (fuera del bucle)
                        $.ajax({
                            url: '/obtenerTiposDefectosOP',
                            type: 'GET',
                            dataType: 'json',
                            success: function(options) {
                                $.each(data, function(index, item) {
                                    var selectHTML =
                                        '<select class="form-control" id="tipoDefectos_' +
                                        index + '">';
                                    $.each(options, function(key, value) {
                                        selectHTML +=
                                            '<option value="' +
                                            value.Defectos + '">' +
                                            value
                                            .Defectos + '</option>';
                                    });
                                    selectHTML += '</select>';
                                    // Identificar select-container con un id único
                                    var selectContainerId =
                                        'select_container_' + index;
                                    $('.select-container', '#collapse' +
                                        index).attr('id',
                                        selectContainerId).html(
                                        selectHTML);
                                });
                            },
                            error: function(error) {
                                console.error(
                                    'Error al cargar opciones del select: ',
                                    error);
                            }
                        });

                    },
                    error: function(error) {
                        console.error('Error al buscar datos de auditoría por estilo: ', error);
                    }
                });
            });
        });

        $(document).on('click', '#Saved', function() {
            var ordenSeleccionada = $('#ordenSelect').val();

            // Obtener los datos del acordeón
            var datosAEnviar = [];
            var acordeon = $(this).closest('.card');
            acordeon.find('tbody tr').each(function(index, fila) {
                var orden = $(fila).find('td:nth-child(2)').text().trim();
                var estilo = $(fila).find('td:nth-child(3)').text().trim();
                var color = $(fila).find('td:nth-child(4)').text().trim();
                var talla = $(fila).find('td:nth-child(5)').text().trim();
                var cantidad = $(fila).find('td:nth-child(6)').text().trim();
                var tipoDefecto = $(fila).find('.select-container select').val();
                var muestreo = $(fila).find('.tamañoMuestra').text().trim();
                var defectos = $(fila).find('.cantidadInput').val(); // Agregar el campo defectos
                var id = $(fila).find('td:nth-child(11)').text().trim();
                // Agregar los datos de la fila al arreglo datosAEnviar
                datosAEnviar.push({
                    id: id,
                    orden: orden,
                    estilo: estilo,
                    color: color,
                    talla: talla,
                    cantidad: cantidad,
                    muestreo: muestreo,
                    defectos: defectos, // Agregar el campo defectos
                    tipoDefecto: tipoDefecto, // Agregar el campo tipoDefecto

                });
            });
            // Realizar la solicitud AJAX para guardar los datos
            $.ajax({
                url: '/guardarInformacionOP',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    orden: ordenSeleccionada,
                    datos: datosAEnviar
                },
                dataType: 'json',
                success: function(response) {
                    // Mostrar mensaje de éxito al usuario
                    alert(response.mensaje);
                },
                error: function(error) {
                    // Mostrar mensaje de error al usuario
                    alert('Error al guardar los datos. Por favor, inténtalo de nuevo.');
                    console.error('Error al guardar los datos: ', error);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Manejar clic en cualquier opción del dropdown
            $('#accordion').on('click', '.dropdown-item', function() {
                // Obtener el valor de la opción seleccionada
                var selectedOption = $(this).attr('value');
                // Obtener el texto del botón de alternancia más cercano (dropdown-toggle)
                var status = $(this).text().trim();
                // Obtener el ID de la fila correspondiente
                var rowId = $(this).data('row-id');

                // Obtener los datos de las filas de la tabla dentro del acordeón actual
                var datosAEnviar = [];
                var acordeon = $(this).closest('.card');
                acordeon.find('tbody tr').each(function(index, fila) {
                    var orden = $(fila).find('td:nth-child(2)').text().trim();
                    var estilo = $(fila).find('td:nth-child(3)').text().trim();
                    var color = $(fila).find('td:nth-child(4)').text().trim();
                    var talla = $(fila).find('td:nth-child(5)').text().trim();
                    var cantidad = $(fila).find('td:nth-child(6)').text().trim();
                    var tipoDefecto = $(fila).find('.select-container select').val();
                    var muestreo = $(fila).find('.tamañoMuestra').text().trim();
                    var defectos = $(fila).find('.cantidadInput')
                        .val(); // Agregar el campo defectos
                    var id = $(fila).find('td:nth-child(11)').text().trim();
                    // Agregar los datos de la fila al arreglo datosAEnviar
                    datosAEnviar.push({
                        id: id,
                        orden: orden,
                        estilo: estilo,
                        color: color,
                        talla: talla,
                        cantidad: cantidad,
                        muestreo: muestreo,
                        defectos: defectos, // Agregar el campo defectos
                        tipoDefecto: tipoDefecto, // Agregar el campo tipoDefecto
                    });
                });
                // Obtener la orden seleccionada
                var ordenSeleccionada = $('#ordenSelect').val();

                // Armar los datos a enviar al servidor
                var datosAEnviar = {
                    _token: '{{ csrf_token() }}',
                    orden: ordenSeleccionada,
                    datos: datosAEnviar, // Datos de las filas de la tabla
                    status: status, // Status seleccionado del dropdown
                    rowId: rowId // ID de la fila seleccionada
                };

                // Realizar la solicitud AJAX para enviar los datos al servidor
                $.ajax({
                    url: '/actualizarStatusOP',
                    type: 'PUT', // Cambiado a PUT
                    data: datosAEnviar,
                    dataType: 'json',
                    success: function(response) {
                        // Manejar la respuesta del servidor
                        alert(response.mensaje); // Mostrar mensaje de éxito al usuario
                    },
                    error: function(error) {
                        // Manejar errores
                        alert('Error al actualizar el status. Por favor, inténtalo de nuevo.');
                        console.error('Error al actualizar el status: ', error);
                    }
                });
            });
        });
    </script>
@endsection
