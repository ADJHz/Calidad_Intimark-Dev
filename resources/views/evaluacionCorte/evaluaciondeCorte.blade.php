@extends('layouts.app', ['activePage' => 'Evaluacion Corte', 'titlePage' => __('Evaluacion Corte')])

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
                            <h3 class="card-title">EVALUACION DE CORTE CONTRA PATRON</h3>
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
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <h4>Orden: {{ $encabezadoAuditoriaCorte->orden_id }}</h4>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <h4>Evento: {{ $encabezadoAuditoriaCorte->evento }}</h4>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <h4>Estilo: {{ $encabezadoAuditoriaCorte->estilo_id }}</h4>
                        </div>
                    </div>
                    <hr>
                    <!--Desde aqui inicia la edicion del codigo para mostrar el contenido-->
                    @php
                        $options = ['-1/16', '-1/8', '-1/4', '-1/2', '0', '+1/2', '+1/4', '+1/8', '+1/16'];
                    @endphp
                    @if($encabezadoAuditoriaCorte->estatus_evaluacion_corte == '1')
                    -
                    @else
                    <form method="POST" action="{{ route('evaluacionCorte.formRegistro') }}">
                        @csrf
                        <input type="hidden" name="orden" value="{{ $encabezadoAuditoriaCorte->orden_id }}">
                        <input type="hidden" name="evento" value="{{ $encabezadoAuditoriaCorte->evento }}">
                        <input type="hidden" name="estilo" value="{{ $encabezadoAuditoriaCorte->estilo_id }}">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Descripción de partes</th>
                                        <th>Izquierda X</th>
                                        <th>Izquierda Y</th>
                                        <th>Derecha X</th>
                                        <th>Derecha Y</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="descripcion_parte" id="descripcion_parte" class="form-control"
                                                required>
                                                <option value="">Seleccione una opción</option>
                                                <option value="DELANTERO">DELANTERO</option>
                                                <option value="TRASERO">TRASERO</option>
                                                <option value="OTRO">OTRO</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="izquierda_x" id="izquierda_x" class="form-control" required>
                                                <option value="">Selecciona una opción</option>
                                                @foreach ($options as $option)
                                                    <option value="{{ $option }}">{{ $option }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="izquierda_y" id="izquierda_y" class="form-control" required>
                                                <option value="">Selecciona una opción</option>
                                                @foreach ($options as $option)
                                                    <option value="{{ $option }}">{{ $option }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="derecha_x" id="derecha_x" class="form-control" required>
                                                <option value="">Selecciona una opción</option>
                                                @foreach ($options as $option)
                                                    <option value="{{ $option }}">{{ $option }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="derecha_y" id="derecha_y" class="form-control" required>
                                                <option value="">Selecciona una opción</option>
                                                @foreach ($options as $option)
                                                    <option value="{{ $option }}">{{ $option }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success">Añadir</button>
                        </div>
                    </form>
                    @endif
                    <hr>

                    <div class="table-responsive">
                        @if($encabezadoAuditoriaCorte->estatus_evaluacion_corte == '1')
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Descripción de partes</th>
                                    <th>Izquierda X</th>
                                    <th>Izquierda Y</th>
                                    <th>Derecha X</th>
                                    <th>Derecha Y</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registroEvaluacionCorte as $item)
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" name="descripcion_parte" id="descripcion_parte" value="{{ $item->descripcion_parte ?? '' }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="izquierda_x" id="izquierda_x" value="{{ $item->izquierda_x ?? '' }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="izquierda_y" id="izquierda_y" value="{{ $item->izquierda_y ?? '' }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="derecha_x" id="derecha_x" value="{{ $item->derecha_x ?? '' }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="derecha_y" id="derecha_y" value="{{ $item->derecha_y ?? '' }}" readonly>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Descripción de partes</th>
                                        <th>Izquierda X</th>
                                        <th>Izquierda Y</th>
                                        <th>Derecha X</th>
                                        <th>Derecha Y</th>
                                        <th>Editar</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($registroEvaluacionCorte as $item)
                                        <form
                                            action="{{ route('evaluacionCorte.formActualizacionEliminacionEvaluacionCorte', ['id' => $item->id]) }}"
                                            method="POST">
                                            @csrf
                                            <tr>
                                                <td>
                                                    <select name="descripcion_parte" id="descripcion_parte" class="form-control" required>
                                                        <option value="">Seleccione una opción</option>
                                                        <option value="DELANTERO" {{ $item->descripcion_parte == 'DELANTERO' ? 'selected' : '' }}>DELANTERO</option>
                                                        <option value="TRASERO" {{ $item->descripcion_parte == 'TRASERO' ? 'selected' : '' }}>TRASERO</option>
                                                        <option value="OTRO" {{ $item->descripcion_parte == 'OTRO' ? 'selected' : '' }}>OTRO</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="izquierda_x" id="izquierda_x" class="form-control" required>
                                                        <option value="">Selecciona una opción</option>
                                                        @foreach ($options as $option)
                                                            <option value="{{ $option }}"
                                                                @if ($item->izquierda_x == $option) selected @endif>
                                                                {{ $option }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="izquierda_y" id="izquierda_y" class="form-control" required>
                                                        <option value="">Selecciona una opción</option>
                                                        @foreach ($options as $option)
                                                            <option value="{{ $option }}"
                                                                @if ($item->izquierda_y == $option) selected @endif>
                                                                {{ $option }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="derecha_x" id="derecha_x" class="form-control" required>
                                                        <option value="">Selecciona una opción</option>
                                                        @foreach ($options as $option)
                                                            <option value="{{ $option }}"
                                                                @if ($item->derecha_x == $option) selected @endif>
                                                                {{ $option }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="derecha_y" id="derecha_y" class="form-control" required>
                                                        <option value="">Selecciona una opción</option>
                                                        @foreach ($options as $option)
                                                            <option value="{{ $option }}"
                                                                @if ($item->derecha_y == $option) selected @endif>
                                                                {{ $option }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <button type="submit" name="action" value="update" class="btn btn-success">Guardar</button>
                                                </td>
                                                <td>
                                                    <button type="submit" name="action" value="delete" class="btn btn-danger">Eliminar</button>
                                                </td>
                                            </tr>
                                        </form>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <hr>
                    @if($encabezadoAuditoriaCorte->estatus_evaluacion_corte == '1')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="observacion" class="col-sm-6 col-form-label">Observaciones:</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" name="observacion" id="observacion" rows="3" placeholder="comentarios" readonly></textarea>
                                </div>
                            </div>
                        </div>
                    @elseif(auth()->check() && auth()->user()->hasRole('Gerente de Calidad'))
                        <form action="{{ route('evaluacionCorte.formFinalizarEventoCorte') }}" method="POST">
                            @csrf
                            <input type="hidden" name="orden" value="{{ $encabezadoAuditoriaCorte->orden_id }}">
                            <input type="hidden" name="evento" value="{{ $encabezadoAuditoriaCorte->evento }}">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="observacion" class="col-sm-6 col-form-label">Observaciones:</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" name="observacion" id="observacion" rows="3" placeholder="comentarios" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <button type="submit" name="action" class="btn btn-danger">Finalizar</button>
                                </div>
                            </div>
                        </form>
                    @endif

                    <!--Fin de la edicion del codigo para mostrar el contenido-->
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Seleccione una opción',
                allowClear: true
            });
        });
    </script>

    <script>
        // Función para cargar la última selección guardada
        function cargarSeleccion() {
            var select = document.getElementById('descripcion_parte');
            var ultimaSeleccion = localStorage.getItem('ultimaSeleccion');
            if (ultimaSeleccion) {
                select.value = ultimaSeleccion;
            }
        }

        // Llama a cargarSeleccion al cargar la página
        window.onload = cargarSeleccion;

        // Función para guardar el valor seleccionado en el almacenamiento local al cambiar la selección
        document.getElementById('descripcion_parte').addEventListener('change', function() {
            localStorage.setItem('ultimaSeleccion', this.value);
        });
    </script>


@endsection
