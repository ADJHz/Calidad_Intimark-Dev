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
    @if (session('status'))
        {{-- A menudo utilizado para mensajes de estado genéricos --}}
        <div class="alert alert-secondary">
            {{ session('status') }}
        </div>
    @endif
    <style>
        .alerta-exito {
            background-color: #28a745;
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
                    <hr>

                    <div class="table-responsive">
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
                                                <input type="text" class="form-control" name="descripcion_parte"
                                                    id="descripcion_parte"
                                                    value="{{ isset($item->descripcion_parte) ? $item->descripcion_parte : '' }}">
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
                                                <button type="submit" class="btn btn-success">Guardar cambios</button>
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </td>
                                        </tr>
                                    </form>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
