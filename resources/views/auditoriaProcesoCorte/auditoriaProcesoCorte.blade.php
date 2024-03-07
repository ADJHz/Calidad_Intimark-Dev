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
                            <h3 class="card-title">AUDITORIA PROCESO DE CORTE</h3>
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
                    <form method="POST" action="{{ route('auditoriaProcesoCorte.formRegistroAuditoriaProcesoCorte') }}">
                        @csrf
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-primary">
                                    <tr>
                                        <th>AREA</th>
                                        <th>ESTILO</th>
                                        <th>SUPERVISOR</th>
                                        <th>AUDITOR</th>
                                        <th>TURNO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" class="form-control" name="area" id="area" value="{{ $data['area'] }}" readonly></td>
                                        <td><input type="text" class="form-control" name="estilo" id="estilo" value="{{ $data['estilo'] }}" readonly></td>
                                        <td><input type="text" class="form-control" name="supervisor_corte" id="supervisor_corte" value="{{ $data['supervisor'] }}" readonly></td>
                                        <td><input type="text" class="form-control" name="auditor" id="auditor" value="{{ $data['auditor'] }}" readonly></td>
                                        <td><input type="text" class="form-control" name="turno" id="turno" value="{{ $data['turno'] }}" readonly></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-primary">
                                    <tr>
                                        <th>NOMBRE 1</th>
                                        <th>NOMBRE 2</th>
                                        <th>OPERACION</th>
                                        <th>LIENZOS TENDIDOS</th>
                                        <th>LIENZOS RECHAZADOS</th>
                                        <th>T.P</th>
                                        <th>A.C</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="nombre_1" id="nombre_1" class="form-control" required
                                                title="Por favor, selecciona una opción">
                                                <option value="">Selecciona una opción</option>
                                                @foreach ($CategoriaTecnico as $nombre)
                                                    <option value="{{ $nombre->nombre }}">
                                                        {{ $nombre->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="nombre_2" id="nombre_2" class="form-control" required
                                                title="Por favor, selecciona una opción">
                                                <option value="">Selecciona una opción</option>
                                                @foreach ($CategoriaTecnico as $nombre2)
                                                    <option value="{{ $nombre2->nombre }}">
                                                        {{ $nombre2->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="operacion" id="operacion" class="form-control" title="Por favor, selecciona una opción" required> 
                                                <option value="Tendedor Electrico">Tendedor Electrico</option>
                                                <option value="Tendedor Manual">Tendedor Manual</option>
                                            </select>
                                        </td>
                                        <td><input type="text" class="form-control" name="cantidad_auditada" id="cantidad_auditada" required></td>
                                        <td><input type="text" class="form-control" name="cantidad_rechazada" id="cantidad_rechazada" required></td>
                                        <td>
                                            @if($data['area'] == "tendido")
                                                <select name="tp" id="tp" class="form-control" required
                                                    title="Por favor, selecciona una opción">
                                                    <option value="">Selecciona una opción</option>
                                                    @foreach ($CategoriaDefectoCorteTendido as $corteTendido)
                                                        <option value="{{ $corteTendido->nombre }}">
                                                            {{ $corteTendido->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            @elseif($data['area'] == "Corte Lectra y Sellado")
                                                <select name="tp" id="tp" class="form-control" required
                                                    title="Por favor, selecciona una opción">
                                                    <option value="">Selecciona una opción</option>
                                                    @foreach ($CategoriaDefectoCorteLectraSellado as $corteTendido)
                                                        <option value="{{ $corteTendido->nombre }}">
                                                            {{ $corteTendido->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            <select name="ac" id="ac" class="form-control" required
                                                title="Por favor, selecciona una opción">
                                                <option value="">Selecciona una opción</option>
                                                @foreach ($CategoriaAccionCorrectiva as $accionCorrectiva)
                                                    <option value="{{ $accionCorrectiva->accion_correctiva }}">
                                                        {{ $accionCorrectiva->accion_correctiva }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-success">Añadir</button>
                    </form>
                    <!--Desde aqui inicia la edicion del codigo para mostrar el contenido-->

                    <div class="table-responsive">
                        <h2>Total Individual</h2>
                        <table class="table">
                            <thead class="thead-primary">
                                <tr>
                                    <th>Nombre 1</th>
                                    <th>Nombre 2</th>
                                    <th>Total de Cantidad Auditada</th>
                                    <th>Total de Cantidad Rechazada</th>
                                    <th>Porcentaje Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrosIndividual as $registro)
                                <tr>
                                    <td>{{ $registro->nombre_1 }}</td>
                                    <td>{{ $registro->nombre_2 }}</td>
                                    <td><input type="text" class="form-control" value="{{ $registro->total_auditada }}" readonly></td>
                                    <td><input type="text" class="form-control" value="{{ $registro->total_rechazada }}" readonly></td>
                                    <td><input type="text" class="form-control" value="{{ $registro->total_rechazada != 0 ? ($registro->total_rechazada / $registro->total_auditada) * 100 : 0 }}" readonly></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="table-responsive">
                        <h2>Total General </h2>
                        <table class="table">
                            <thead class="thead-primary">
                                <tr>
                                    <th>total de cantidad Lienzos Tendidos</th>
                                    <th>total de cantidad Lienzos Rechazados</th>
                                    <th>Porcentaje Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" class="form-control" name="total_auditada" id="total_auditada" value="{{ $total_auditada }}" readonly></td>
                                    <td><input type="text" class="form-control" name="total_rechazada" id="total_rechazada" value="{{ $total_rechazada }}" readonly></td>
                                    <td><input type="text" class="form-control" name="total_porcentaje" id="total_porcentaje" value="{{ $total_porcentaje }}" readonly></td>
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
            background-color: #59666e54; /* Azul claro */
            color: #333; /* Color del texto */
        }
    </style>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Seleccione una opción',
                allowClear: true
            });
        });
    </script>






@endsection
