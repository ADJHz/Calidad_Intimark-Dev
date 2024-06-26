@extends('layouts.app', ['activePage' => 'AQL', 'titlePage' => __('AQL')])

@section('content')
    {{-- ... dentro de tu vista ... --}}
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alerta-exito">
            {{ session('success') }}
            @if (session('sorteo'))
                <br>{{ session('sorteo') }}
            @endif
        </div>
    @endif
    @if (session('sobre-escribir'))
        <div class="alert sobre-escribir">
            {{ session('sobre-escribir') }}
        </div>
    @endif
    @if (session('status'))
        {{-- A menudo utilizado para mensajes de estado genéricos --}}
        <div class="alert alert-secondary">
            {{ session('status') }}
        </div>
    @endif
    @if (session('cambio-estatus'))
        <div class="alert cambio-estatus">
            {{ session('cambio-estatus') }}
        </div>
    @endif
    <style>
        .alerta-exito {
            background-color: #32CD32;
            /* Color de fondo verde */
            color: white;
            /* Color de texto blanco */
            padding: 20px;
            border-radius: 15px;
            font-size: 20px;
        }

        .sobre-escribir {
            background-color: #FF8C00;
            /* Color de fondo verde */
            color: white;
            /* Color de texto blanco */
            padding: 20px;
            border-radius: 15px;
            font-size: 20px;
        }

        .cambio-estatus {
            background-color: #800080;
            /* Color de fondo verde */
            color: white;
            /* Color de texto blanco */
            padding: 20px;
            border-radius: 15px;
            font-size: 20px;
        }
    </style>
    {{-- ... el resto de tu vista ... --}}
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <!--Aqui se edita el encabezado que es el que se muestra -->
                <div class="card-header card-header-primary">
                    <div class="row align-items-center justify-content-between">
                        <div class="col">
                            <h3 class="card-title">{{ $data['area'] }}</h3>
                        </div>
                        <div class="col-auto">
                            <h4>Fecha:
                                {{ now()->format('d ') . $mesesEnEspanol[now()->format('n') - 1] . now()->format(' Y') }}
                            </h4>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    @if((($conteoParos == 2) && ($finParoModular1 == true)) || (($conteoParos == 4) && ($finParoModular2 == true)))
                        <div class="row">
                            <form method="POST" action="{{ route('auditoriaAQL.cambiarEstadoInicioParoAQL') }}">
                                @csrf
                                <input type="hidden" name="finalizar_paro_modular" value="1">
                                <input type="hidden" class="form-control" name="modulo" id="modulo" value="{{ $data['modulo'] }}">
                                <input type="hidden" class="form-control" name="op" id="op" value="{{ $data['op'] }}">
                                <input type="hidden" class="form-control" name="area" id="area" value="{{ $data['area'] }}">
                                <input type="hidden" class="form-control" name="team_leader" id="team_leader" value="{{ $data['team_leader'] }}">


                                <button type="submit" class="btn btn-primary">Fin Paro Modular</button>
                            </form>
                        </div>
                    @else
                        <form method="POST" action="{{ route('auditoriaAQL.formRegistroAuditoriaProcesoAQL') }}">
                            @csrf
                            <input type="hidden" class="form-control" name="area" id="area"
                                value="{{ $data['area'] }}">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th>MODULO</th>
                                            <th>OP</th>
                                            <th>CLIENTE</th>
                                            <th>TEAM LEADER</th>
                                            <th>AUDITOR</th>
                                            <th>TURNO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" class="form-control" name="modulo" id="modulo"
                                                    value="{{ $data['modulo'] }}" readonly></td>
                                            <td><input type="text" class="form-control" name="op" id="op"
                                                    value="{{ $data['op'] }}" readonly></td>
                                            <td><input type="text" class="form-control" name="cliente" id="cliente"
                                                    value="{{ $datoUnicoOP->customername }}" readonly></td>
                                            <td><input type="text" class="form-control" name="team_leader" id="team_leader"
                                                    value="{{ $data['team_leader'] }}" readonly></td>
                                            <td><input type="text" class="form-control" name="auditor" id="auditor"
                                                    value="{{ $data['auditor'] }}" readonly></td>
                                            <td><input type="text" class="form-control" name="turno" id="turno"
                                                    value="{{ $data['turno'] }}" readonly></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            @if ($estatusFinalizar)
                            @else
                                <div class="table-responsive">
                                    <table class="table table32"> 
                                        <thead class="thead-primary">
                                            <tr>
                                                <th>NOMBRE</th>
                                                <th># BULTO</th>
                                                <th>PIEZAS</th>
                                                <th>ESTILO</th>
                                                <th>COLOR</th>
                                                <th>TALLA</th>
                                                <th>PIEZAS INSPECCIONADAS</th>
                                                <th>PIEZAS RECHAZADAS</th>
                                                <th>TIPO DE DEFECTO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select name="nombre" id="nombre" class="form-control" required>
                                                        <option value="">Selecciona una opción</option>
                                                        @if($auditorPlanta == 'Planta1')
                                                            @foreach($nombreProcesoToAQLPlanta1 as $opcion)
                                                                <option value="{{ $opcion['nombre'] ?? $opcion['name'] }}">{{ $opcion['nombre'] ?? $opcion['name'] }}</option>
                                                            @endforeach
                                                        @elseif($auditorPlanta == 'Planta2')
                                                            @foreach($nombreProcesoToAQLPlanta2 as $opcion)
                                                                <option value="{{ $opcion['nombre'] ?? $opcion['name'] }}">{{ $opcion['nombre'] ?? $opcion['name'] }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="bulto" id="bulto" class="form-control" required title="Por favor, selecciona una opción">
                                                        <option value="">Selecciona una opción</option>
                                                        @foreach ($datoBultos as $bulto)
                                                            <option value="{{ $bulto->prodpackticketid }}" data-estilo="{{ $bulto->itemid }}" data-color="{{ $bulto->colorname }}" data-talla="{{ $bulto->inventsizeid }}" data-pieza="{{ $bulto->qty }}">
                                                                {{ $bulto->prodpackticketid }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="pieza" id="pieza" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="estilo" id="estilo" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="color" id="color" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="talla" id="talla" readonly>
                                                </td>
                                                
                                                <script>
                                                    $(document).ready(function() {
                                                        $('#bulto').change(function() {
                                                            var selectedOption = $(this).find(':selected');
                                                            $('#pieza').val(selectedOption.data('pieza'));
                                                            $('#estilo').val(selectedOption.data('estilo'));
                                                            $('#color').val(selectedOption.data('color'));
                                                            $('#talla').val(selectedOption.data('talla'));
                                                        });
                                                
                                                        // Actualizar valores al cargar la página si una opción está seleccionada por defecto
                                                        var selectedOption = $('#bulto').find(':selected');
                                                        $('#pieza').val(selectedOption.data('pieza'));
                                                        $('#estilo').val(selectedOption.data('estilo'));
                                                        $('#color').val(selectedOption.data('color'));
                                                        $('#talla').val(selectedOption.data('talla'));
                                                    });
                                                </script>                                            
                                                
                                                <td><input type="numbre" class="form-control" name="cantidad_auditada"
                                                        id="cantidad_auditada" required></td>
                                                <td>
                                                    <input type="text" class="form-control" name="cantidad_rechazada" id="cantidad_rechazada" required>
                                                </td>
                                                <script>
                                                    $(document).ready(function() {
                                                      $('#cantidad_rechazada').on('input', function() {
                                                        const cantidadRechazada = parseInt($(this).val());
                                                        const nombreSelect = $('#nombre');
                                                  
                                                        if (cantidadRechazada === 0) {
                                                          nombreSelect.prop('required', false);
                                                        } else {
                                                          nombreSelect.prop('required', true);
                                                        }
                                                      });
                                                    });
                                                  </script>
                                                  
                                                <td>
                                                    <select name="tp[]" id="tpSelectAQL" class="form-control" required multiple title="Por favor, selecciona una opción"> 
                                                        <option value="NINGUNO">NINGUNO</option>
                                                        <option value="OTRO">OTRO</option>
                                                        @if ($data['area'] == 'AUDITORIA AQL')
                                                            @foreach ($categoriaTPProceso as $proceso)
                                                                <option value="{{ $proceso->nombre }}">{{ $proceso->nombre }}</option>
                                                            @endforeach
                                                        @elseif($data['area'] == 'AUDITORIA AQL PLAYERA')
                                                            @foreach ($categoriaTPPlayera as $playera)
                                                                <option value="{{ $playera->nombre }}">{{ $playera->nombre }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="submit" class="btn btn-success">Guardar</button>
                            @endif
                        </form>
                        <!-- Modal -->
                        <div class="modal fade" id="nuevoConceptoModalAQL" tabindex="-1" role="dialog" aria-labelledby="nuevoConceptoModalLabelAQL" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content bg-dark text-white">
                                    <div class="modal-header">
                                        <h5 id="nuevoConceptoModalLabelAQL">Introduce el nuevo concepto</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true" class="text-white">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" class="form-control bg-dark text-white" id="nuevoConceptoInputAQL" placeholder="Nuevo concepto">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-primary" id="guardarNuevoConceptoAQL">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <hr>
                    <!--Desde aqui inicia la edicion del codigo para mostrar el contenido-->
                    @if ($mostrarRegistro)
                        @if ($estatusFinalizar)
                            <h2>Registro</h2>
                            <table class="table table56"> 
                                <thead class="thead-primary">
                                    <tr>
                                        <th>PARO</th>
                                        <th># BULTO</th>
                                        <th>PIEZAS</th>
                                        <th>TALLA</th>
                                        <th>COLOR</th>
                                        <th>ESTILO</th>
                                        <th>PIEZAS INSPECCIONADAS</th>
                                        <th>PIEZAS RECHAZADAS</th>
                                        <th>TIPO DE DEFECTO</th>
                                        <th>Hora</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mostrarRegistro as $registro)
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="minutos_paro"
                                                value="&nbsp;{{ $registro->minutos_paro }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="bulto"
                                                value="{{ $registro->bulto }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="pieza"
                                                value="{{ $registro->pieza }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="talla"
                                                value="{{ $registro->talla }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="color" id="color"
                                                value="{{$registro->color}}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="estilo" id="estilo"
                                                value="{{$registro->estilo}}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="cantidad_auditada" id="cantidad_auditada"
                                                value="{{$registro->cantidad_auditada}}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="cantidad_rechazada" id="cantidad_rechazada"
                                                value="{{$registro->cantidad_rechazada}}" readonly>
                                            </td>
                                            
                                            <form action="{{ route('auditoriaAQL.formUpdateDeleteProceso') }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $registro->id }}">
                                                <td>
                                                    <input type="text" class="form-control" readonly
                                                           value="{{ implode(', ', $registro->tpAuditoriaAQL->pluck('tp')->toArray()) }}">
                                                </td>
                                                <td>
                                                    {{ $registro->created_at->format('H:i:s') }}
                                                </td>
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table> 
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="observacion" class="col-sm-6 col-form-label">Observaciones:</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" name="observacion" id="observacion" rows="3" readonly>{{ $registro->observacion }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="table-responsive">
                                <h2>Registro</h2>

                                <table class="table table55">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th>PARO</th>
                                            <th># BULTO</th>
                                            <th>PIEZAS</th>
                                            <th>TALLA</th>
                                            <th>COLOR</th>
                                            <th>ESTILO</th>
                                            <th>PIEZAS INSPECCIONADAS</th>
                                            <th>PIEZAS RECHAZADAS</th>
                                            <th>TIPO DE DEFECTO</th>
                                            <th>Eliminar </th>
                                            <th>Hora</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mostrarRegistro as $registro)
                                            <tr>
                                                <td>
                                                    @if($registro->inicio_paro == NULL)
                                                        -
                                                    @elseif($registro->fin_paro != NULL)
                                                        {{$registro->minutos_paro}}
                                                    @elseif($registro->fin_paro == NULL)
                                                        <form method="POST" action="{{ route('auditoriaAQL.cambiarEstadoInicioParoAQL') }}">
                                                            @csrf
                                                            <input type="hidden" name="idCambio" value="{{ $registro->id }}">
                                                            <button type="submit" class="btn btn-primary">Fin Paro AQL</button>
                                                        </form>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="bulto"
                                                    value="{{ $registro->bulto }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="pieza"
                                                    value="{{ $registro->pieza }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="talla"
                                                    value="{{ $registro->talla }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="color" id="color"
                                                    value="{{$registro->color}}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="estilo" id="estilo"
                                                    value="{{$registro->estilo}}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="cantidad_auditada" id="cantidad_auditada"
                                                    value="{{$registro->cantidad_auditada}}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="cantidad_rechazada" id="cantidad_rechazada"
                                                    value="{{$registro->cantidad_rechazada}}" readonly>
                                                </td>
                                                
                                                <form action="{{ route('auditoriaAQL.formUpdateDeleteProceso') }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $registro->id }}">
                                                    <td>
                                                        <input type="text" class="form-control" readonly
                                                               value="{{ implode(', ', $registro->tpAuditoriaAQL->pluck('tp')->toArray()) }}">
                                                    </td>
                                                    <td>
                                                        <button type="submit" name="action" value="delete"
                                                            class="btn btn-danger">Eliminar</button>
                                                    </td>
                                                    <td>
                                                        {{ $registro->created_at->format('H:i:s') }}
                                                    </td>
                                                </form>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <form action="{{ route('auditoriaAQL.formFinalizarProceso') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="area" value="{{ $data['area'] }}">
                                    <input type="hidden" name="modulo" value="{{ $data['modulo'] }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="observacion"
                                                class="col-sm-6 col-form-label">Observaciones:</label>
                                            <div class="col-sm-12">
                                                <textarea class="form-control" name="observacion" id="observacion" rows="3" placeholder="comentarios"
                                                    required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <button type="submit" name="action"
                                                class="btn btn-danger">Finalizar</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        @endif
                    @else
                        <div>
                            <h2> sin registros el dia de hoy</h2>
                        </div>
                    @endif
                    <hr>
                    <div class="table-responsive">
                        <h2>Piezas auditadas por dia</h2>
                        <table class="table">
                            <thead class="thead-primary">
                                <tr>
                                    <th>Total de piezas Muestra Auditadas </th>
                                    <th>Total de piezas Muestra Rechazadas</th>
                                    <th>Porcentaje AQL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registrosIndividual as $registro)
                                    <tr>
                                        <td><input type="text" class="form-control"
                                                value="{{ $registro->total_auditada }}" readonly></td>
                                        <td><input type="text" class="form-control"
                                                value="{{ $registro->total_rechazada }}" readonly></td>
                                        <td><input type="text" class="form-control"
                                                value="{{ $registro->total_rechazada != 0 ? number_format(($registro->total_rechazada / $registro->total_auditada) * 100, 2) : 0 }}"
                                                readonly></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <table class="table contenedor-tabla">
                        <thead class="thead-primary">
                            <tr>
                                <th>Total de piezas en bultos Auditados</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registrosIndividualPieza as $registro)
                                <tr>
                                    <td><input type="text" class="form-control"
                                        value="{{ $registro->total_pieza }}" readonly></td>
                                        {{--
                                        <td><input type="text" class="form-control"
                                                value="{{ $registro->total_rechazada }}" readonly></td>
                                        <td><input type="text" class="form-control"
                                                value="{{ $registro->total_rechazada != 0 ? number_format(($registro->total_rechazada / $registro->total_pieza) * 100, 2) : 0 }}"
                                                readonly></td>
                                        --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <hr>
                    <div class="table-responsive">
                        <h2>Total por Bultos </h2>
                        <table class="table">
                            <thead class="thead-primary">
                                <tr>
                                    <th>total de Bultos Auditados</th>
                                    <th>total de Bultos Rechazados</th>
                                    <th>Porcentaje Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" name="conteo_bulto"
                                            id="conteo_bulto" value="{{ $conteoBultos }}" readonly></td>
                                    <td><input type="text" class="form-control" name="total_rechazada"
                                            id="total_rechazada" value="{{ $conteoPiezaConRechazo }}" readonly></td>
                                    <td><input type="text" class="form-control" name="total_porcentaje"
                                            id="total_porcentaje" value="{{ number_format($porcentajeBulto, 2) }}"
                                            readonly></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--Fin de la edicion del codigo para mostrar el contenido-->
                </div>
            </div>
        </div>
    </div>

    <style>
        thead.thead-primary {
            background-color: #59666e54;
            /* Azul claro */
            color: #333;
            /* Color del texto */
        }

        .table32 th:nth-child(2) {
            min-width: 150px;
            /* Ajusta el ancho mínimo según tu necesidad */
        }
        .table32 th:nth-child(9) {
            min-width: 200px;
            /* Ajusta el ancho mínimo según tu necesidad */
        }
        .table32 th:nth-child(4) {
            min-width: 100px;
            /* Ajusta el ancho mínimo según tu necesidad */
        }

        .table32 th:nth-child(5) {
            min-width: 150px;
            /* Ajusta el ancho mínimo según tu necesidad */
        }


        .table55 th:nth-child(1) {
            min-width: 150px;
            /* Ajusta el ancho mínimo según tu necesidad */
        }

        .table56 th:nth-child(1) {
            min-width: 10px;
            /* Ajusta el ancho mínimo según tu necesidad */
        }
        

        /* Estilo general para el contenedor de la tabla */
        .contenedor-tabla {
            width: 30%; /* Ajusta el ancho según tus necesidades */
            
        }


        @media (max-width: 768px) {
            .table23 th:nth-child(3) {
                min-width: 100px;
                /* Ajusta el ancho mínimo para móviles */
            }
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#bulto').select2({
                placeholder: 'Seleccione una o varias opciones',
                allowClear: true,
            });
            $('#tpSelectAQL').select2({
                placeholder: 'Seleccione una o varias opciones',
                allowClear: true,
                multiple: true
            });

            $('#tpSelectAQL').on('change', function() {
                let selectedOptions = $(this).val();
                if (selectedOptions.includes('OTRO')) {
                    $('#nuevoConceptoModalAQL').modal('show');
                }
            });

            $('#guardarNuevoConceptoAQL').on('click', function() {
                let nuevoConcepto = $('#nuevoConceptoInputAQL').val();
                if (nuevoConcepto) {
                    let area = '';
                    @if ($data['area'] == 'AUDITORIA AQL')
                        area = 'proceso';
                    @elseif($data['area'] == 'AUDITORIA AQL PLAYERA')
                        area = 'playera';
                    @endif

                    fetch('{{ route('categoria_tipo_problema_aql.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            nombre: nuevoConcepto.toUpperCase(),
                            area: area
                        })
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            let newOption = new Option(nuevoConcepto.toUpperCase(), nuevoConcepto.toUpperCase(), true, true);
                            $('#tpSelectAQL').append(newOption).trigger('change');
                            $('#nuevoConceptoModalAQL').modal('hide');
                        } else {
                            alert('Error al guardar el nuevo concepto');
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        alert('Error al guardar el nuevo concepto');
                    });
                } else {
                    alert('Por favor, introduce un concepto válido');
                }
            });

            $('#nuevoConceptoModalAQL').on('hidden.bs.modal', function () {
                $('#nuevoConceptoInputAQL').val('');
                let selectedOptions = $('#tpSelectAQL').val();
                let index = selectedOptions.indexOf('OTRO');
                if (index > -1) {
                    selectedOptions.splice(index, 1);
                    $('#tpSelectAQL').val(selectedOptions).trigger('change');
                }
            });
        });
    </script>


@endsection
