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
                            <h3 class="card-title">{{$data['area']}}</h3>
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
                    <form method="POST" action="{{ route('aseguramientoCalidad.formRegistroAuditoriaProceso') }}">
                        @csrf
                        <input type="hidden" class="form-control" name="area" id="area" value="{{ $data['area'] }}">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-primary">
                                    <tr>
                                        <th>MODULO</th>
                                        <th>ESTILO</th>
                                        <th>TEAM LEADER</th>
                                        <th>AUDITOR</th>
                                        <th>TURNO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" class="form-control" name="modulo" id="modulo" value="{{ $data['modulo'] }}" readonly></td>
                                        <td><input type="text" class="form-control" name="estilo" id="estilo" value="{{ $data['estilo'] }}" readonly></td>
                                        <td><input type="text" class="form-control" name="team_leader" id="team_leader" value="{{ $data['team_leader'] }}" readonly></td>
                                        <td><input type="text" class="form-control" name="auditor" id="auditor" value="{{ $data['auditor'] }}" readonly></td>
                                        <td><input type="text" class="form-control" name="turno" id="turno" value="{{ $data['turno'] }}" readonly></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table flex-container">
                                <thead class="thead-primary">
                                    <tr>
                                        <th>NOMBRE</th>
                                        <th>OPERACION</th>
                                        <th>LIENZOS</th>
                                        <th>LIENZOS RECHAZADOS</th>
                                        <th>T.P</th>
                                        <th>A.C</th>
                                        @if($data['area'] == 'AUDITORIA EN EMPAQUE')
                                        @else
                                            <th>P x P</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> 
                                            <select name="nombre" id="nombre" class="form-control" required
                                                title="Por favor, selecciona una opción" >
                                                <option value="">Selecciona una opción</option>
                                                @if ($auditorPlanta == 'Planta1')
                                                    @foreach ($nombresPlanta1 as $nombre)
                                                        <option value="{{ $nombre->name }}">{{ $nombre->name }}</option>
                                                    @endforeach
                                                @elseif($auditorPlanta == 'Planta2')
                                                    @foreach ($nombresPlanta2 as $nombre)
                                                        <option value="{{ $nombre->name }}">{{ $nombre->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td> 
                                        <td><input type="text" class="form-control" name="operacion" id="operacion" required></td>
                                        <td><input type="text" class="form-control" name="cantidad_auditada" id="cantidad_auditada" required></td>
                                        <td><input type="text" class="form-control" name="cantidad_rechazada" id="cantidad_rechazada" required></td>
                                        <td>
                                            <select name="tp" id="tp" class="form-control" required
                                                title="Por favor, selecciona una opción">
                                                <option value="">Selecciona una opción</option>
                                                    @if($data['area'] == 'AUDITORIA EN PROCESO')
                                                        @foreach ($categoriaTPProceso as $proceso)
                                                            <option value="{{ $proceso->nombre }}">{{ $proceso->nombre }}</option>
                                                        @endforeach
                                                    @elseif($data['area'] == 'AUDITORIA EN PROCESO PLAYERA')
                                                        @foreach ($categoriaTPPlayera as $playera)
                                                            <option value="{{ $playera->nombre }}">{{ $playera->nombre }}</option>
                                                        @endforeach
                                                    @elseif($data['area'] == 'AUDITORIA EN EMPAQUE')
                                                        @foreach ($categoriaTPEmpaque as $empque)
                                                            <option value="{{ $empque->nombre }}">{{ $empque->nombre }}</option>
                                                        @endforeach
                                                    @endif
                                            </select>
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            @if($data['area'] == 'AUDITORIA EN EMPAQUE')
                                            @else
                                                <input type="text" class="form-control" name="pxp" id="pxp" required>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-success">Añadir</button>
                    </form>
                    <hr>
                    <!--Desde aqui inicia la edicion del codigo para mostrar el contenido-->
                    @if($mostrarRegistro)
                        <div class="table-responsive"> 
                            <h2>Registro</h2>  
                            <table class="table"> 
                                <thead class="thead-primary"> 
                                    <tr> 
                                        <th>Nombre</th> 
                                        <th>Operacion </th>
                                        <th>Lienzo tendido</th> 
                                        <th>Lienzo rechazado</th> 
                                        <th>T. P. </th>  
                                        <th>Accion Correctiva </th>  
                                    </tr> 
                                </thead>  
                                <tbody> 
                                    @foreach($mostrarRegistro as $registro) 
                                    <tr> 
                                        <td>{{ $registro->nombre }}</td> 
                                        <td>{{ $registro->operacion }}</td> 
                                        <td>{{ $registro->cantidad_auditada }}</td> 
                                        <td>{{ $registro->cantidad_rechazada }}</td> 
                                        <td>{{ $registro->tp }}</td> 
                                        <td>{{ $registro->ac }}</td> 
                                    </tr> 
                                    @endforeach 
                                </tbody> 
                            </table> 
                        </div>
                    @else
                        <div>
                            <h2> sin registros el dia de hoy</h2>
                        </div>
                    @endif
                    <hr>
                    <div class="table-responsive">
                        <h2>Total Individual</h2>
                        <table class="table">
                            <thead class="thead-primary">
                                <tr>
                                    <th>Nombre </th>
                                    <th>Total de Cantidad Auditada</th>
                                    <th>Total de Cantidad Rechazada</th>
                                    <th>Porcentaje Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrosIndividual as $registro)
                                <tr>
                                    <td>{{ $registro->nombre }}</td>
                                    <td><input type="text" class="form-control" value="{{ $registro->total_auditada }}" readonly></td>
                                    <td><input type="text" class="form-control" value="{{ $registro->total_rechazada }}" readonly></td>
                                    <td><input type="text" class="form-control" value="{{ $registro->total_rechazada != 0 ? round(($registro->total_rechazada / $registro->total_auditada) * 100, 2) : 0 }}" readonly></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr>
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
                                    <td><input type="text" class="form-control" name="total_porcentaje" id="total_porcentaje" value="{{ number_format($total_porcentaje, 2) }}" readonly></td>
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

        .table th:nth-child(3) {
            min-width: 120px; /* Ajusta el ancho mínimo según tu necesidad */
        }
        .table th:nth-child(4) {
            min-width: 120px; /* Ajusta el ancho mínimo según tu necesidad */
        }

        .table th:nth-child(9) {
            min-width: 200px; /* Ajusta el ancho mínimo según tu necesidad */
        }
        .table th:nth-child(10) {
            min-width: 150px; /* Ajusta el ancho mínimo según tu necesidad */
        }

        @media (max-width: 768px) {
        .table th:nth-child(3) {
            min-width: 100px; /* Ajusta el ancho mínimo para móviles */
        }
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
