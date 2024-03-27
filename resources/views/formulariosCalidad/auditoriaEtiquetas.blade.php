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
                    </div>
                    <br>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success" id="Buscar">
                            Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="card" style="width: auto;">
                    <div class="card-header card-header-primary">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="card-title">{{ __('Auditoría.') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="messages">
                        <div class="card-body table-responsive">
                            <table class="table" id="miTabla">
                                <thead class="text-primary">
                                    <tr>
                                        <th
                                            style="text-align: left; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: 1px;">
                                            #</th>
                                        <th>
                                            No/Orden</th>
                                        <th>
                                            Estilos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-danger" id="Finalizar">
                                                <span>Finalizar</span>
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- Agrega la clase 'modal-lg' para hacer el modal más ancho -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles de la Fila</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Aquí se mostrarán los detalles de la fila seleccionada -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


    </div>
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
        });
    </script>
    <script>
        $(document).ready(function() {
            // Controlador para el botón de búsqueda
            $('#Buscar').click(function() {
                var ordenSeleccionada = $('#ordenSelect').val();
                if (ordenSeleccionada) {
                    $.ajax({
                        url: '/buscarDatosAuditoria',
                        type: 'GET',
                        data: {
                            orden: ordenSeleccionada
                        },
                        dataType: 'json',
                        success: function(data) {
                            // Limpiar tabla antes de agregar resultados
                            $('#miTabla tbody').empty();
                            // Mostrar resultados en la tabla
                            $.each(data, function(index, item) {
                                $('#miTabla tbody').append('<tr><td>' + (index + 1) +
                                    '</td><td>' + item.OrdenCompra + '</td><td>' +
                                    item.Estilos + '</td></tr>');
                            });
                        },
                        error: function(error) {
                            console.error('Error al buscar datos de auditoría: ', error);
                        }
                    });
                } else {
                    console.error('No se ha seleccionado ninguna orden.');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Controlador de eventos para clic en fila de la tabla
            $('#miTabla tbody').on('click', 'tr', function() {
                // Eliminar la clase de selección de todas las filas
                $('#miTabla tbody tr').removeClass('selected');
                // Agregar la clase de selección a la fila clicada
                $(this).addClass('selected');
                // Obtener la orden seleccionada
                var ordenSeleccionada = $(this).find('td:nth-child(2)').text();
                var estiloSeleccionado = $(this).find('td:nth-child(3)').text(); // Obtener el estilo de la fila seleccionada
                // Realizar la solicitud AJAX para obtener los datos específicos para el modal
                $.ajax({
                    url: '/buscarDatosAuditoriaModal',
                    type: 'GET',
                    data: {
                        orden: ordenSeleccionada,
                        estilo: estiloSeleccionado // Agregar el estilo seleccionado aquí
                    },
                    dataType: 'json',
                    success: function(data) {
                        // Mostrar los datos en el modal
                        var modalContent = '';
                        $.each(data, function(index, item) {
                            modalContent += '<p>Estilos: ' + item.Estilos + '</p>';
                            modalContent += '<p>Talla: ' + item.Talla + '</p>';
                            modalContent += '<p>Color: ' + item.Color + '</p>';
                            modalContent += '<p>Cantidad: ' + item.Cantidad + '</p>';
                            modalContent += '<p>Lotes: ' + item.Lotes + '</p>';
                        });
                        $('#modalBody').html(modalContent);
                        // Abrir el modal
                        $('#myModal').modal('show');
                    },
                    error: function(error) {
                        console.error('Error al buscar datos de auditoría para el modal: ',
                            error);
                    }
                });
    
            });
        });
    </script>
    
@endsection
