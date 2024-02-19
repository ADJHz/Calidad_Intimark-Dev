@extends('layouts.app', ['activePage' => 'ScreenPrint', 'titlePage' => __('Screen Print')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header card-header-primary">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">{{ __('Screen Print.') }}</h3>
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
                        </div>
                        <div class="col-md-2">
                            <label for="clienteSelect">Seleccion de cliente:</label>
                            <select class="form-control" id="clienteSelect" name="clienteSelect" required>
                                <!-- Las opciones se cargarán dinámicamente aquí -->
                            </select>

                        </div>
                        <div class="col-md-2">
                            <label for="estiloSelect">Seleccion de estilo:</label>
                            <select class="form-control" id="estiloSelect" name="estiloSelect" required>
                                <!-- Las opciones se cargarán dinámicamente aquí -->
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="ordenSelect">Seleccion de op:</label>
                            <select class="form-control" id="ordenSelect" name="ordenSelect" required>
                                <!-- Las opciones se cargarán dinámicamente aquí -->
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="tecnicosSelect">Seleccion del tecnico:</label>
                            <select class="form-control" id="tecnicosSelect" name="tecnicosSelect" required>
                                <!-- Las opciones se cargarán dinámicamente aquí -->
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="inputColor">Ingresa color:</label>
                            <input class="form-control" id="inputColor" name="inputColor" required>

                        </div>
                        <div class="col-md-2">
                            <label for="inputGrafico">Ingresa # de Grafico:</label>
                            <input class="form-control" id="inputGrafico" name="inputGrafico" required>
                        </div>
                        <div class="col-md-2">
                            <label for="tecnicaSelect">Seleccion de tipo de tecnica:</label>
                            <select class="form-control" id="tecnicaSelect" name="tecnicaSelect" required>
                                <!-- Las opciones se cargarán dinámicamente aquí -->
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="fibraSelect">Seleccion de tipo de fibra:</label>
                            <select class="form-control" id="fibraSelect" name="fibraSelect[]" required>
                                <!-- Las opciones se cargarán dinámicamente aquí -->
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="card-title">{{ __('Defectos detectados.') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="miTabla" class="table">
                            <thead class="text-info">
                                <th style="text-align: center">ID</th>
                                <th style="text-align: center">Auditor</th>
                                <th style="text-align: center">Cliente</th>
                                <th style="text-align: center">Estilo</th>
                                <th style="text-align: center">OP</th>
                                <th style="text-align: center">Tecnico</th>
                                <th style="text-align: center">Color</th>
                                <th style="text-align: center"># Grafico</th>
                                <th style="text-align: center">Tecnica</th>
                                <th style="text-align: center">Fibras</th>
                                <th style="text-align: center">% de Fibras</th>
                                <th style="text-align: center">Tipo Defectos</th>
                                <th style="text-align: center">Acciones Correctivas</th>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8" style="text-align: left;">
                                        <button type="button" class="button" id="insertarFila">
                                            <span class="button__text">Add row</span>
                                            <span class="button__icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke-linejoin="round" stroke-linecap="round" stroke="currentColor"
                                                    height="24" fill="none" class="svg">
                                                    <line y2="19" y1="5" x2="12" x1="12">
                                                    </line>
                                                    <line y2="12" y1="12" x2="19" x1="5">
                                                    </line>
                                                </svg></span>
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                            <div style="text-align: right; float: right;">
                                <button type="button" class="button" id="Finalizar">
                                    <div class="svg-wrapper-1">
                                        <div class="svg-wrapper">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24"
                                                height="24">
                                                <path fill="none" d="M0 0h24v24H0z"></path>
                                                <path fill="currentColor"
                                                    d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <span>Finalizar</span>
                                </button>
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Inicializar Select2 para el cliente
            $('#clienteSelect').select2({
                placeholder: 'Seleccione un cliente',
                allowClear: true
            });
            $('#estiloSelect').select2({
                placeholder: 'Seleccione un estilo',
                allowClear: true
            });
            // Inicializar Select2 para la orden
            $('#ordenSelect').select2({
                placeholder: 'Seleccione una orden',
                allowClear: true
            });
            // Inicializar Select2 para la orden
            $('#tecnicosSelect').select2({
                placeholder: 'Seleccione un tecnico',
                allowClear: true
            });
            $('#tecnicaSelect').select2({
                placeholder: 'Seleccione una tecnica',
                allowClear: true
            });
            // Contenedor para los inputs
            var contenedorInputs = $('<div>', {
                class: 'col-md-2 style: text-align: right;'
            });

            // Agregar el contenedor después del Select2
            $('.select2-container').parent().append(contenedorInputs);

            $('#fibraSelect').select2({
                placeholder: 'Seleccione una o varias fibras',
                allowClear: true,
                multiple: true // Esta opción permite la selección múltiple
            });

            // Función para crear los inputs
            function crearInputs(selectedOptions) {
                // Limpiar contenedor anterior
                contenedorInputs.empty();

                // Crear un input para cada opción seleccionada
                if (selectedOptions && selectedOptions.length > 0) {
                    // Contenedor para los inputs en línea
                    var contenedorInputsEnLinea = $('<div>', {
                        class: 'col-md-12 d-flex'
                    });

                    // Variable para almacenar la suma de los porcentajes
                    var sumaPorcentajes = 0;

                    $.each(selectedOptions, function(index, fibra) {
                        var porcentajeInput = $('<input>', {
                            type: 'number',
                            class: 'porcentajeInput form-control mr-2',
                            name: 'porcentajeInput[]',
                            placeholder: '% para ' + fibra,
                            min: 0,
                            max: 100,
                            required: true,
                            style: 'width: 150px;' // Ajusta el ancho según tus preferencias
                        });

                        // Etiqueta para el nombre de la fibra
                        var etiquetaFibra = $('<label>', {
                            text: fibra + ': ',
                            class: 'mr-2'
                        });

                        // Contenedor individual para cada fibra
                        var contenedorFibra = $('<div>', {
                            class: 'd-flex align-items-center'
                        });

                        contenedorFibra.append(etiquetaFibra);
                        contenedorFibra.append(porcentajeInput);

                        // Agregar el contenedor de fibra al contenedor general
                        contenedorInputsEnLinea.append(contenedorFibra);

                        // Evento de cambio en el input de porcentaje
                        porcentajeInput.on('input', function() {
                            // Actualizar la suma de los porcentajes al cambiar el valor
                            sumaPorcentajes = calcularSumaPorcentajes();
                            validarSumaPorcentajes();
                        });
                    });

                    // Agregar el contenedor de inputs en línea al contenedor general
                    contenedorInputs.append(contenedorInputsEnLinea);

                    // Función para calcular la suma de los porcentajes
                    function calcularSumaPorcentajes() {
                        var suma = 0;
                        $('.porcentajeInput').each(function() {
                            suma += parseFloat($(this).val()) || 0;
                        });
                        return suma;
                    }

                    // Función para validar y ajustar la suma de los porcentajes
                    function validarSumaPorcentajes() {
                        if (sumaPorcentajes > 100) {
                            alert(
                                'La suma de los porcentajes no puede superar el 100%. Se ajustará automáticamente.'
                            );
                            // Ajustar automáticamente el último porcentaje ingresado
                            var ultimoInput = $('.porcentajeInput').last();
                            var nuevoValor = 100 - (sumaPorcentajes - parseFloat(ultimoInput.val()));
                            ultimoInput.val(nuevoValor);
                            sumaPorcentajes = calcularSumaPorcentajes();
                        }
                    }
                }
            }
            // Inicializar los inputs al cargar la página
            crearInputs($('#fibraSelect').val());

            $('#fibraSelect').on('select2:select select2:unselect', function(e) {
                var selectedOptions = $(this).val();

                // Crear o actualizar los inputs al seleccionar o quitar opciones
                crearInputs(selectedOptions);
            });

            // Agregar el contenedor de inputs después del último div dentro de card-body
            $('.card-body .row').append(contenedorInputs);


            // Cargar las opciones de los clientes desde la base de datos
            $.ajax({
                url: '/Clientes', // Ajusta la URL según tu ruta
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Limpiar las opciones existentes
                    $('#clienteSelect').empty();
                    // Agregar la opción predeterminada
                    $('#clienteSelect').append($('<option>', {
                        disabled: true,
                        selected: true
                    }));
                    // Agregar las nuevas opciones desde la respuesta del servidor
                    $.each(data, function(key, value) {
                        $('#clienteSelect').append($('<option>', {
                            text: value.cliente
                        }));
                    });
                },
                error: function(error) {
                    console.error('Error al cargar opciones de clientes: ', error);
                }
            });

            // Evento de cambio en el select de clientes
            $('#clienteSelect').on('change', function() {
                var clienteSeleccionado = $(this).val();

                // Cargar las opciones de las ordenes relacionadas al cliente seleccionado
                $.ajax({
                    url: '/Estilo/' +
                        clienteSeleccionado, // Ajusta la URL según tu ruta y la lógica en tu controlador
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Limpiar las opciones existentes
                        $('#estiloSelect').empty();
                        // Agregar la opción predeterminada
                        $('#estiloSelect').append($('<option>', {
                            disabled: true,
                            selected: true
                        }));
                        // Agregar las nuevas opciones desde la respuesta del servidor
                        $.each(data, function(key, value) {
                            $('#estiloSelect').append($('<option>', {
                                text: value.estilo
                            }));
                        });
                    },
                    error: function(error) {
                        console.error('Error al cargar opciones de ordenes: ', error);
                    }
                });
            });
            $('#estiloSelect').on('change', function() {
                var estiloSeleccionado = $(this).val();

                // Cargar las opciones de las ordenes relacionadas al cliente seleccionado
                $.ajax({
                    url: '/Ordenes/' +
                        estiloSeleccionado, // Ajusta la URL según tu ruta y la lógica en tu controlador
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Limpiar las opciones existentes
                        $('#ordenSelect').empty();
                        // Agregar la opción predeterminada
                        $('#ordenSelect').append($('<option>', {
                            disabled: true,
                            selected: true
                        }));
                        // Agregar las nuevas opciones desde la respuesta del servidor
                        $.each(data, function(key, value) {
                            $('#ordenSelect').append($('<option>', {
                                text: value.orden
                            }));
                        });
                    },
                    error: function(error) {
                        console.error('Error al cargar opciones de ordenes: ', error);
                    }
                });
            });
            $.ajax({
                url: '/Tecnicos', // Ajusta la URL según tu ruta
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Limpiar las opciones existentes
                    $('#tecnicosSelect').empty();
                    // Agregar la opción predeterminada
                    $('#tecnicosSelect').append($('<option>', {
                        disabled: true,
                        selected: true
                    }));
                    // Agregar las nuevas opciones desde la respuesta del servidor
                    $.each(data, function(key, value) {
                        $('#tecnicosSelect').append($('<option>', {
                            text: value.Nom_Tecnico
                        }));
                    });
                },
                error: function(error) {
                    console.error('Error al cargar opciones de Tecnicos: ', error);
                }

            });
            $.ajax({
                url: '/TipoTecnica', // Ajusta la URL según tu ruta
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Limpiar las opciones existentes
                    $('#tecnicaSelect').empty();
                    // Agregar la opción predeterminada
                    $('#tecnicaSelect').append($('<option>', {
                        disabled: true,
                        selected: true
                    }));
                    // Agregar las nuevas opciones desde la respuesta del servidor
                    $.each(data, function(key, value) {
                        $('#tecnicaSelect').append($('<option>', {
                            text: value.Tipo_tecnica
                        }));
                    });
                },
                error: function(error) {
                    console.error('Error al cargar opciones de clientes: ', error);
                }
            });
            $.ajax({
                url: '/TipoFibra', // Ajusta la URL según tu ruta
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Limpiar las opciones existentes
                    $('#fibraSelect').empty();
                    // Agregar las nuevas opciones desde la respuesta del servidor
                    $.each(data, function(key, value) {
                        $('#fibraSelect').append($('<option>', {
                            text: value.Tipo_Fibra
                        }));
                    });
                },
                error: function(error) {
                    console.error('Error al cargar opciones de clientes: ', error);
                }
            });

            $('#tecnicaSelect').on('change', function() {
                var tecnicaSeleccionada = $(this).val();

                // Si el usuario selecciona 'Otra', mostrar un prompt para ingresar una nueva opción
                if (tecnicaSeleccionada === 'Otra') {
                    var nuevaTecnica = prompt('Por favor, ingresa la nueva técnica');

                    // Si el usuario ingresó una nueva técnica, enviarla al servidor
                    if (nuevaTecnica) {
                        $.ajax({
                            url: '/AgregarTecnica', // Ajusta la URL según tu ruta
                            type: 'POST',
                            data: {
                                nuevaTecnica: nuevaTecnica,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                // Agregar la nueva opción a la lista desplegable
                                $('#tecnicaSelect').append($('<option>', {
                                    text: nuevaTecnica
                                }));
                                // Seleccionar la nueva opción
                                $('#tecnicaSelect').val(nuevaTecnica);
                            },
                            error: function(error) {
                                console.error('Error al agregar nueva técnica: ', error);
                            }
                        });
                    }
                }
            });
            $('#fibraSelect').on('change', function() {
                var fibrasSeleccionadas = $(this).val();

                // Verificar si 'Otra' está entre las opciones seleccionadas
                if (Array.isArray(fibrasSeleccionadas) && fibrasSeleccionadas.includes('Otra')) {
                    var nuevafibra = prompt('Por favor, ingresa la nueva fibra');

                    // Si el usuario ingresó una nueva fibra, enviarla al servidor
                    if (nuevafibra) {
                        $.ajax({
                            url: '/AgregarFibra',
                            type: 'POST',
                            data: {
                                nuevafibra: nuevafibra,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                // Agregar la nueva opción a la lista desplegable
                                $('#fibraSelect').append($('<option>', {
                                    text: nuevafibra,
                                    value: nuevafibra
                                }));
                                // Seleccionar la nueva opción
                                fibrasSeleccionadas.push(nuevafibra);
                                $('#fibraSelect').val(fibrasSeleccionadas);
                            },
                            error: function(error) {
                                console.error('Error al agregar nueva fibra: ', error);
                            }
                        });
                    }
                }
            });
        });
    </script>
    <script>
        var lastRegisteredId = 0;
        var addRowClicked = false;

        $(document).ready(function() {
            // Hacer la llamada Ajax al servidor para obtener datos
            $.ajax({
                url: '/viewTable', // Ruta de tu servidor Laravel
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    try {
                        // Limpiar la tabla antes de agregar nuevas filas
                        $('#miTabla tbody').empty();

                        // Iterar sobre los datos recibidos y agregar filas a la tabla
                        $.each(data, function(index, item) {
                            var isGuardado = item.Status === 'Nuevo' || item.Status ==='Update';
                            var readonlyAttribute = isGuardado ? '' : 'readonly';
                            var disabledAttribute = isGuardado ? '' : 'disabled';

                            var row = '<tr>' +
                                '<td><input type="text" name="id" class="form-control" value="' +
                                item.id +
                                '" readonly></td>' +
                                '<td><input type="text" name="Auditor" class="form-control" value="' +
                                item.Auditor +
                                '" readonly></td>' +
                                '<td><input type="text" name="Cliente" class="form-control" value="' +
                                item.Cliente +
                                '" ' + readonlyAttribute + '></td>' +
                                '<td><input type="text" name="Estilo" class="form-control" value="' +
                                item.Estilo +
                                '" ' + readonlyAttribute + '></td>' +
                                '<td><input type="text" name="OP_Defec" class="form-control" value="' +
                                item
                                .OP_Defec + '" ' + readonlyAttribute + '></td>' +
                                '<td><input type="text" name="Tecnico" class="form-control" value="' +
                                item
                                .Tecnico + '" ' + readonlyAttribute + '></td>' +
                                '<td><input type="text" name="Color" class="form-control" value="' +
                                item.Color +
                                '" ' + readonlyAttribute + '></td>' +
                                '<td><input type="text" name="Num_Grafico" class="form-control" value="' +
                                item
                                .Num_Grafico + '" ' + readonlyAttribute + '></td>' +
                                '<td><input type="text" name="Tecnica" class="form-control" value="' +
                                item
                                .Tecnica + '" ' + readonlyAttribute + '></td>' +
                                '<td><input type="text" name="Fibras" class="form-control" value="' +
                                item
                                .Fibras + '" ' + readonlyAttribute + '></td>' +
                                '<td><input type="text" name="Porcen_Fibra" class="form-control" value="' +
                                item
                                .Porcen_Fibra + '" ' + readonlyAttribute + '></td>' +
                                '<td><input type="text" name="Tipo_Problema" class="form-control" value="' +
                                item
                                .Tipo_Problema + '" ' + readonlyAttribute + '></td>' +
                                '<td><input type="text" name="Ac_Correctiva" class="form-control" value="' +
                                item
                                .Ac_Correctiva + '" ' + readonlyAttribute + '></td>' +
                                '<td><button type="button" class="btn btn-primary guardarFila updateFile" ' +
                                disabledAttribute + '>Guardar</button></td>' +
                                '</tr>';

                            $('#miTabla tbody').append(row);
                            lastRegisteredId = item.id;
                        });
                    } catch (error) {
                        console.error('Error al procesar los datos:', error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la llamada Ajax:', status, error);
                }
            });
        });
    </script>


    <script>
        var addRowClicked = false;

        function cargarOpcionesACCorrectiva() {
            $.ajax({
                url: '/obtenerOpcionesACCorrectiva', // Ajusta la ruta según tu configuración
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    llenarSelect('ac_correctivaR[]', data, 'Seleccione Acción Correctiva');
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener opciones de ac_correctivaR[]:', status, error);
                }
            });
        }

        function cargarOpcionesTipoProblema() {
            $.ajax({
                url: '/obtenerOpcionesTipoProblema', // Ajusta la ruta según tu configuración
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    llenarSelect('tipo_problemaR[]', data, 'Seleccione Tipo de Problema');
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener opciones de tipo_problemaR[]:', status, error);
                }
            });
        }

        function llenarSelect(nombreSelect, opciones) {
            var select = $('.form-control[name="' + nombreSelect + '"]');
            select.empty();

            select.select2({
                placeholder: 'Seleccione una opcion',
                allowClear: true
            });


            opciones.forEach(function(opcion) {
                select.append('<option value="' + opcion + '">' + opcion + '</option>');
            });

            select.select2();
        }

        $('#insertarFila').on('click', function() {
            console.log('Se hizo clic en el botón "AddRow"');
            addRowClicked = true;

            lastRegisteredId++;

            var auditor = '{{ Auth::user()->name }}';
            var cliente = $('#clienteSelect').val();
            var estilo = $('#estiloSelect').val();
            var op = $('#ordenSelect').val();
            var tecnico = $('#tecnicosSelect').val();
            var color = $('#inputColor').val();
            var numGrafico = $('#inputGrafico').val();
            var tecnica = $('#tecnicaSelect').val();
            var fibras = $('#fibraSelect').val();
            var tipoProblema = $('#tipoProblemaSelect').val();
            var acCorrectiva = $('#acCorrectivaSelect').val();

            var porcentajes = [];
            $('.porcentajeInput').each(function() {
                porcentajes.push($(this).val());
            });

            var newRow = '<tr>' +
                '<td><input type="hidden" name="idR[]" value="' + lastRegisteredId + '"></td>' +
                '<td><input type="text" name="auditorR[]" class="form-control" value="' + auditor +
                '" readonly></td>' +
                '<td><input type="text" name="clienteR[]" class="form-control" value="' + cliente +
                '"></td>' +
                '<td><input type="text" name="estiloR[]" class="form-control" value="' + estilo +
                '"></td>' +
                '<td><input type="text" name="op_defecR[]" class="form-control" value="' + op +
                '"></td>' +
                '<td><input type="text" name="tecnicoR[]" class="form-control" value="' + tecnico +
                '"></td>' +
                '<td><input type="text" name="colorR[]" class="form-control" value="' + color +
                '"></td>' +
                '<td><input type="text" name="num_graficoR[]" class="form-control" value="' +
                numGrafico + '"></td>' +
                '<td><input type="text" name="tecnicaR[]" class="form-control" value="' + tecnica +
                '"></td>' +
                '<td><input type="text" name="fibrasR[]" class="form-control" value="' + fibras.join(', ') +
                '"></td>' +
                '<td><input type="text" name="porcentaje_fibraR[]" class="form-control" value="' +
                porcentajes.join(', ') + '"></td>' +
                '<td><select class="form-control" name="tipo_problemaR[]"></select></td>' +
                '<td><select class="form-control" name="ac_correctivaR[]"></select></td>' +
                '<td><button type="button" class="btn btn-primary guardarFila updateFile">Guardar</button></td>' +
                '</tr>';

            $('#miTabla tbody').append(newRow);

            // Cargar opciones de los nuevos select
            cargarOpcionesACCorrectiva();
            cargarOpcionesTipoProblema();
        });

        $(document).ready(function() {
            cargarOpcionesACCorrectiva();
            cargarOpcionesTipoProblema();
        });
        // Evento de clic en el botón "Guardar"
        $(document).on('click', '.guardarFila', function() {
            console.log('Se hizo clic en el botón "Guardar"');
            // Obtener el token CSRF
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            // Verificar si se hizo clic en el botón "AddRow"
            if (addRowClicked) {
                // Obtener los valores de la fila desde los campos de entrada
                var auditorValue = $(this).closest('tr').find('[name="auditorR[]"]').val();
                var clienteValue = $(this).closest('tr').find('[name="clienteR[]"]').val();
                var estiloValue = $(this).closest('tr').find('[name="estiloR[]"]').val();
                var opDefecValue = $(this).closest('tr').find('[name="op_defecR[]"]').val();
                var tecnicoValue = $(this).closest('tr').find('[name="tecnicoR[]"]').val();
                var colorValue = $(this).closest('tr').find('[name="colorR[]"]').val();
                var numGraficoValue = $(this).closest('tr').find('[name="num_graficoR[]"]').val();
                var tecnicaValue = $(this).closest('tr').find('[name="tecnicaR[]"]').val();
                var fibrasValue = $(this).closest('tr').find('[name="fibrasR[]"]').val();
                var porcentajeFibraValue = $(this).closest('tr').find('[name="porcentaje_fibraR[]"]').val();
                var tipoProblemaValue = $(this).closest('tr').find('[name="tipo_problemaR[]"]').val();
                var acCorrectivaValue = $(this).closest('tr').find('[name="ac_correctivaR[]"]').val();
                $.ajax({
                    url: '/SendScreenPrint',
                    method: 'POST',
                    data: {
                        _token: csrfToken,
                        addRowClicked: addRowClicked,
                        Auditor: auditorValue,
                        Cliente: clienteValue,
                        Estilo: estiloValue,
                        OP_Defec: opDefecValue,
                        Tecnico: tecnicoValue,
                        Color: colorValue,
                        Num_Grafico: numGraficoValue,
                        Tecnica: tecnicaValue,
                        Fibras: fibrasValue,
                        Porcen_Fibra: porcentajeFibraValue,
                        Tipo_Problema: tipoProblemaValue,
                        Ac_Correctiva: acCorrectivaValue
                    },
                    success: function(response) {
                        // Realizar acciones adicionales si es necesario después de la respuesta exitosa
                        console.log(response);
                    },
                    error: function(error) {
                        // Manejar errores si es necesario
                        console.log('Error en la solicitud POST:', error);
                    }
                });
            }
        });
    </script>
    <script>
        var lastRegisteredId = 0;

        // Evento de clic en el botón "Guardar"
        $(document).on('click', '.updateFile', function() {
            console.log('Se hizo clic en el botón "Guardar"');
            // Obtener el token CSRF
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Obtener los valores de la fila desde los campos de entrada
            var row = $(this).closest('tr');
            var idValue = row.find('input[name="id"]')
                .val(); // Asegúrate de obtener el valor correcto del campo "id"
            var addRowClicked = row.find('input[name="id"]').length === 0; // Verifica si es una fila agregada

            // Obtener otros valores de la fila
            var auditorValue = row.find('input[name="Auditor"]').val();
            var clienteValue = row.find('input[name="Cliente"]').val();
            var estiloValue = row.find('input[name="Estilo"]').val();
            var opDefecValue = row.find('input[name="OP_Defec"]').val();
            var tecnicoValue = row.find('input[name="Tecnico"]').val();
            var colorValue = row.find('input[name="Color"]').val();
            var numGraficoValue = row.find('input[name="Num_Grafico"]').val();
            var tecnicaValue = row.find('input[name="Tecnica"]').val();
            var fibrasValue = row.find('input[name="Fibras"]').val();
            var porcentajeFibraValue = row.find('input[name="Porcen_Fibra"]').val();
            var tipoProblemaValue = row.find('input[name="Tipo_Problema"]').val();
            var acCorrectivaValue = row.find('input[name="Ac_Correctiva"]').val();
            // Continuar con la solicitud AJAX
            $.ajax({
                url: '/UpdateScreenPrint/' + idValue,
                method: 'PUT',
                data: {
                    _token: csrfToken,
                    addRowClicked: false,
                    id: idValue,
                    Auditor: auditorValue,
                    Cliente: clienteValue,
                    Estilo: estiloValue,
                    OP_Defec: opDefecValue,
                    Tecnico: tecnicoValue,
                    Color: colorValue,
                    Num_Grafico: numGraficoValue,
                    Tecnica: tecnicaValue,
                    Fibras: fibrasValue,
                    Porcen_Fibra: porcentajeFibraValue,
                    Tipo_Problema: tipoProblemaValue,
                    Ac_Correctiva: acCorrectivaValue
                },
                success: function(response) {
                    // Realizar acciones adicionales si es necesario después de la respuesta exitosa
                    console.log(response);
                },
                error: function(error) {
                    // Manejar errores si es necesario
                    console.log(addRowClicked ? 'Error en la solicitud POST:' :
                        'Error en la solicitud PUT:', error);
                },
                complete: function() {
                    // Recargar la página después de completar la solicitud
                    location.reload();
                }
            });
        });
    </script>
@endsection
