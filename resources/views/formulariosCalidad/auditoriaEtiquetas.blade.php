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
                                            style="text-align: left; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .01%">
                                            #</th>
                                        <th  style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;">
                                            No/Orden</th>
                                        <th   style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;">
                                            Estilos</th>
                                        <th   style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;">
                                            Color</th>
                                        <th   style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;">
                                            Talla</th>
                                        <th   style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;">
                                            Cantidad</th>
                                        <th   style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;">
                                            Tamaño Muestra</th>
                                        <th   style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: .1%;">
                                            Defectos</th>
                                        <th   style="text-align: center; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; width: 1%;">
                                            Tipo Defectos</th>
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
                                        <td>
                                            <button type="button" class="btn btn-success" id="Saved">
                                                <span>Guardar</span>
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
<style>
    .rechazado {
        background-color: #d91f1f; /* Fondo rojo */
        color: #fff; /* Texto blanco */
    }

    .rechazado td {
        border: 1px solid #fff; /* Borde blanco */
    }
</style>

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
                            // Formatear la cantidad
                            var cantidadFormateada = item.Cantidad;
                            var puntoIndex = cantidadFormateada.indexOf('.');
                            if (puntoIndex !== -1) {
                                var parteDecimal = cantidadFormateada.substring(puntoIndex + 1);
                                if (parteDecimal.length > 2) {
                                    parteDecimal = parteDecimal.substring(0, 2);
                                }
                                cantidadFormateada = cantidadFormateada.substring(0, puntoIndex + 1) + parteDecimal;
                            }
                            // Verificar si el tamaño de muestra está en el rango de 2 a 20
                            var tamañoMuestra = parseInt(item.tamaño_muestra);
                            var inputHTML = '<input type="number" class="form-control" id="cantidadInput_' + index + '" value="0">';
                            // Verificar si el tamaño de muestra está en el rango específico
                            if (tamañoMuestra == 32 || tamañoMuestra == 50 || tamañoMuestra == 80 || tamañoMuestra == 125 || tamañoMuestra == 200 || tamañoMuestra == 315 || tamañoMuestra == 500 || tamañoMuestra == 800 || tamañoMuestra == 2000) {
                                inputHTML = '<input type="number" class="form-control" id="cantidadInput_' + index + '" value="0">';
                            }
                            // Agregar fila a la tabla
                            var fila = '<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td style="text-align: center;">' + item.OrdenCompra + '</td>' +
                                '<td style="text-align: center;">' + item.Estilos + '</td>' +
                                '<td style="text-align: center;">' + item.Color + '</td>' +
                                '<td style="text-align: center;">' + item.Talla + '</td>' +
                                '<td style="text-align: center;">' + cantidadFormateada + '</td>' +
                                '<td style="text-align: center;">' + item.tamaño_muestra + '</td>' +
                                '<td style="text-align: center; position: relative;">' +
                                inputHTML +
                                '</td>' +
                                '<td id="leyenda_' + index + '" style="text-align: center;"></td>' +
                                '</tr>';
                            $('#miTabla tbody').append(fila);
                        });

                        // Agregar controlador de eventos para validar los inputs
                        $('input[type="number"]').on('change', function() {
                            var index = $(this).attr('id').split('_')[1];
                            var cantidad = parseInt($(this).val());
                            var tamañoMuestra = parseInt(data[index].tamaño_muestra);
                            if (isNaN(cantidad)) {
                                cantidad = 0;
                            }
                            if ((tamañoMuestra == 32 && cantidad > 1) ||
                                (tamañoMuestra == 50 && cantidad > 2) ||
                                (tamañoMuestra == 80 && cantidad > 3) ||
                                (tamañoMuestra == 125 && cantidad > 5) ||
                                (tamañoMuestra == 200 && cantidad > 7) ||
                                (tamañoMuestra == 315 && cantidad > 10) ||
                                (tamañoMuestra == 500 && cantidad > 14) ||
                                (tamañoMuestra == 800 && cantidad > 21) ||
                                (tamañoMuestra == 2000 && cantidad > 28)) {
                                $('#leyenda_' + index).text('Rechazado');
                                marcarFilaRechazada(index);
                            } else {
                                $('#leyenda_' + index).text('');
                                desmarcarFilaRechazada(index);
                            }
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

        // Función para marcar la fila como rechazada
        function marcarFilaRechazada(index) {
            $('#miTabla tbody tr').eq(index).addClass('rechazado');
        }

        // Función para desmarcar la fila como rechazada
        function desmarcarFilaRechazada(index) {
            $('#miTabla tbody tr').eq(index).removeClass('rechazado');
        }
    });
</script>



@endsection
