@extends('layouts.app', ['activePage' => 'proceso', 'titlePage' => __('proceso')])

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
                            <h3 class="card-title">AUDITORIA CONTROL DE CALIDAD</h3>
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
                    <form method="POST" action="{{ route('auditoriaAQL.formAltaProceso') }}">
                        @csrf
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-primary">
                                    <tr>
                                        <th>AREA</th>
                                        <th>MODULO</th>
                                        <th>OP</th>
                                        <th>AUDITOR</th>
                                        <th>TURNO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="area" id="area" class="form-control" required>
                                                <option value="">Selecciona una opción</option>
                                                <option value="AUDITORIA AQL">AUDITORIA AQL</option>
                                                <option value="AUDITORIA AQL PLAYERA">AUDITORIA AQL PLAYERA</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="modulo" id="modulo" class="form-control" required
                                                title="Por favor, selecciona una opción">
                                                <option value="" selected>Selecciona una opción</option>
                                                <!-- Agrega el atributo selected aquí -->
                                                @if ($auditorPlanta == 'Planta1')
                                                    @foreach ($auditoriaProcesoIntimark1 as $moduloP1)
                                                        <option value="{{ $moduloP1->moduleid }}"
                                                            data-itemid="{{ $moduloP1->itemid }}">
                                                            {{ $moduloP1->moduleid }}
                                                        </option>
                                                    @endforeach
                                                @elseif($auditorPlanta == 'Planta2')
                                                    @foreach ($auditoriaProcesoIntimark2 as $moduloP2)
                                                        <option value="{{ $moduloP2->moduleid }}"
                                                            data-itemid="{{ $moduloP2->itemid }}">
                                                            {{ $moduloP2->moduleid }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="estilo" id="estilo"
                                                placeholder="estilo" readonly /></td>
                                        <td><input type="text" class="form-control me-2" name="auditor" id="auditor"
                                                value="{{ $auditorDato }}" readonly required /></td>
                                        <td><input type="text" class="form-control me-2" name="turno" id="turno"
                                                value="1" readonly required /></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-success">Iniciar</button>
                    </form>
                    <hr>
                    <!--Desde aqui inicia la edicion del codigo para mostrar el contenido-->

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
    </style>
    <script>
        $(document).ready(function() {
            $('#modulo').select2({
                placeholder: 'Seleccione una opción',
                allowClear: true
            });

            $('#modulo').on('select2:select', function(e) {
                var itemid = e.params.data.element.dataset.itemid;
                $('#estilo').val(itemid);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#modulo').change(function() {
                var itemid = $(this).find(':selected').data('itemid');
                $('#estilo').val(itemid);
            });
        });
    </script>





@endsection
