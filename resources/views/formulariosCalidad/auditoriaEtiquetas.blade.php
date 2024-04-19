@extends('layouts.app', ['activePage' => 'Etiquetas', 'titlePage' => __('Etiquetas')])
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">{{ __('Auditoria Etiquetas.') }}</h3>
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
            $.ajax({
                url: '/NoOrdenes',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Limpiar las opciones existentes
                    $('#ordenSelect').empty();
                    // Agregar la opción predeterminada
                    $('#ordenSelect').append($('<option>', {
                        disabled: true,
                        selected: true,
                    }));
                    // Agregar las nuevas opciones desde la respuesta del servidor
                    $.each(data, function(key, value) {
                        $('#ordenSelect').append($('<option>', {
                            text: value.OrdenCompra
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
                        url: '/buscarEstilos',
                        type: 'GET',
                        data: {
                            orden: orden
                        },
                        dataType: 'json',
                        success: function(data) {
                            // Limpiar los acordeones existentes
                            $('#accordion').empty();
                            // Generar acordeones para cada estilo encontrado
                            // Generar acordeones para cada estilo encontrado
                            $.each(data, function(key, value) {
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
                                    'Estilo: ' + value.Estilos + '</span>';
                                accordion += '<span style="font-size: 18px;">' +
                                    'Status: ' + +'</span>';
                                accordion += '</button>';
                                accordion += '</h2>';
                                accordion += '</div>';
                                accordion += '<div id="collapse' + key +
                                    '" class="collapse" aria-labelledby="heading' +
                                    key + '" data-parent="#accordion">';
                                accordion += '<div class="card-body">';
                                // Contenido del acordeon
                                accordion += '<div class="tab-pane" id="messages">';
                                accordion += '<div class="card-body table-responsive">';
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
                                    '<th style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;"></th>';
                                accordion +=
                                    '<th style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;">Defectos</th>';
                                accordion +=
                                    '<th style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: 1%;">Tipo Defectos</th>';
                                accordion += '</tr>';
                                accordion += '</thead>';
                                accordion += '<tbody>';
                                accordion += '</tbody>';
                                accordion += '<tfoot>';
                                accordion += '<tr>';
                                accordion += '<td>';
                                accordion += '<div class="dropup-center dropup">';
                                accordion += '<button id="dropdownToggle_' + key +
                                    '" class="btn btn-danger dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">';
                                accordion += 'Opciones';
                                accordion += '</button>';
                                accordion +=
                                    '<ul class="dropdown-menu" aria-labelledby="dropdownToggle_' +
                                    key + '">';
                                accordion +=
                                    '<li><a class="dropdown-item text-success" value="Aprovado">Aprobado</a></li>';
                                accordion +=
                                    '<li><a class="dropdown-item text-warning" value="Aprovado Condicionalmente">Aprobado Condicionalmente</a></li>';
                                accordion +=
                                    '<li><a class="dropdown-item text-danger" value="Rechazado">Rechazado</a></li>';
                                accordion += '</ul>';
                                accordion += '</div>';
                                accordion += '</td>';
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
                url: '/buscarDatosAuditoriaPorEstilo',
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
                        // Formatear la cantidad
                        var cantidadFormateada = item.Cantidad;
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
                        // Verificar si el tamaño de muestra está en el rango de 2 a 20
                        var tamañoMuestra = parseInt(item.tamaño_muestra);
                        var inputHTML =
                            '<input type="number" class="form-control cantidadInput" id="cantidadInput_' +
                            index + '_acordeon_' + estilo + '" value="0">'; // Modificado: agregado '_acordeon_' + estilo
                        // Verificar si el tamaño de muestra está en el rango específico
                        if (tamañoMuestra == 32 || tamañoMuestra == 50 ||
                            tamañoMuestra == 80 || tamañoMuestra == 125 ||
                            tamañoMuestra == 200 || tamañoMuestra == 315 ||
                            tamañoMuestra == 500 || tamañoMuestra == 800 ||
                            tamañoMuestra == 2000) {
                            inputHTML =
                                '<td style="text-align: center;"><input type="number" class="form-control cantidadInput" id="cantidadInput_' +
                                index + '_acordeon_' + estilo + '" value="0"></td>'; // Modificado: agregado '_acordeon_' + estilo
                        }
                        // Agregar fila a la tabla
                        var fila = '<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td style="text-align: center;">' + item.OrdenCompra +
                            '</td>' +
                            '<td style="text-align: center;">' + item.Estilos +
                            '</td>' +
                            '<td style="text-align: center;">' + item.Color +
                            '</td>' +
                            '<td style="text-align: center;">' + item.Talla +
                            '</td>' +
                            '<td style="text-align: center;">' +
                            cantidadFormateada +
                            '</td>' +
                            '<td style="text-align: center;"><span class="tamañoMuestra">' +
                            item.tamaño_muestra + '</span></td>' +
                            '<td style="text-align: center; position: relative;">' +
                            inputHTML +
                            '</td>' +
                            '<td class="select-container" style="text-align: center;"></td>' +
                            '</tr>';
                        $('#miTabla tbody').append(fila);
                    });
                    // Cargar opciones del select mediante AJAX (fuera del bucle)
                    $.ajax({
                        url: '/obtenerTiposDefectos',
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
                                        value.Defectos + '">' + value
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
                    // Agregar controlador de eventos para validar los inputs
                    $('.cantidadInput').on('change', function() {
                        var index = $(this).attr('id').split('_')[1];
                        var cantidad = parseInt($('#cantidadInput_' + index + '_acordeon_' + estilo).val()); // Modificado: agregado '_acordeon_' + estilo
                        var tamañoMuestra = parseInt($('.tamañoMuestra').eq(index).text());

                        if (isNaN(cantidad)) {
                            cantidad = 0;
                        }
                        // Ajustar la lógica de comparación
                        if ((tamañoMuestra === 32 && cantidad > 1) ||
                            (tamañoMuestra === 50 && cantidad > 2) ||
                            (tamañoMuestra === 80 && cantidad > 3) ||
                            (tamañoMuestra === 125 && cantidad > 5) ||
                            (tamañoMuestra === 200 && cantidad > 7) ||
                            (tamañoMuestra === 315 && cantidad > 10) ||
                            (tamañoMuestra === 500 && cantidad > 14) ||
                            (tamañoMuestra === 800 && cantidad > 21) ||
                            (tamañoMuestra === 2000 && cantidad > 28)) {
                            $('#leyenda_' + index).text('Rechazado');
                            marcarFilaRechazada(index);
                        } else {
                            $('#leyenda_' + index).text('');
                            desmarcarFilaRechazada(index);
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
        $('#miTabla tbody tr').each(function(index, fila) {
            var orden = $(fila).find('td:nth-child(2)').text().trim();
            var estilo = $(fila).find('td:nth-child(3)').text().trim();
            var color = $(fila).find('td:nth-child(4)').text().trim();
            var talla = $(fila).find('td:nth-child(5)').text().trim();
            var cantidad = $(fila).find('td:nth-child(6)').text().trim();
            var tipoDefecto = $(fila).find('.select-container select').val();
            var muestreo = $(fila).find('.tamañoMuestra').text().trim();
            var defectos = $(fila).find('.cantidadInput').val(); // Agregar el campo defectos

            // Agregar los datos de la fila al arreglo datosAEnviar
            datosAEnviar.push({
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

        // Mostrar los datos antes de enviarlos
        alert("Datos a enviar al servidor: " + JSON.stringify(datosAEnviar));

        // Realizar la solicitud AJAX para guardar los datos
        $.ajax({
            url: '/guardarInformacion',
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



@endsection
