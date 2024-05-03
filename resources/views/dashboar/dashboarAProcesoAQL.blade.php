@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('dashboard')])

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
                            <h3 class="card-title">Dashboard Auditoria AQL</h3>
                        </div>
                        <div class="col-auto">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <!--Desde aqui inicia la edicion del codigo para mostrar el contenido-->
                    <form action="{{ route('dashboar.dashboarAProcesoAQL') }}" method="GET" id="filterForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_inicio">Fecha de inicio</label>
                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_fin">Fecha de fin</label>
                                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Mostrar datos</button>
                    </form>
                    
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            // Obtener los parámetros de la URL
                            const urlParams = new URLSearchParams(window.location.search);
                            const fechaInicio = urlParams.get('fecha_inicio');
                            const fechaFin = urlParams.get('fecha_fin');
                    
                            // Establecer los valores de los campos de fecha
                            document.getElementById("fecha_inicio").value = fechaInicio || '';
                            document.getElementById("fecha_fin").value = fechaFin || '';
                    
                            // Manejar el evento de envío del formulario
                            document.getElementById("filterForm").addEventListener("submit", function(event) {
                                // Agregar los valores de los campos de fecha a la URL del formulario
                                const fechaInicioValue = document.getElementById("fecha_inicio").value;
                                const fechaFinValue = document.getElementById("fecha_fin").value;
                                this.action = "{{ route('dashboar.dashboarAProcesoAQL') }}?fecha_inicio=" + fechaInicioValue + "&fecha_fin=" + fechaFinValue;
                            });
                        });
                    </script>
                    <hr>                    
                    <table class="table  table-bordered table1">
                        <thead class="thead-custom1 text-center">
                            <tr>
                                <th>Cliente</th>
                                <th>% Error</th>
                                <!-- Aquí puedes agregar más encabezados si es necesario -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($porcentajesError as $cliente => $porcentajeError)
                                <tr class="{{ ($porcentajeError > 9 && $porcentajeError <= 15) ? 'error-bajo' : ($porcentajeError > 15 ? 'error-alto' : '') }}">
                                    <td>{{ $cliente }}</td>
                                    <td>{{ number_format($porcentajeError, 2) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-bordered ">
                        <thead class="thead-custom2 text-center">
                            <tr>
                                <th>Modulo</th>
                                <th>OP</th>
                                <th>Team Leader</th>
                                <th>% Error</th>
                                <!-- Aquí puedes agregar más encabezados si es necesario -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($porcentajesErrorNombre as $nombre => $porcentajeErrorNombre)
                                <tr class="{{ ($porcentajeErrorNombre > 9 && $porcentajeErrorNombre <= 15) ? 'error-bajo' : ($porcentajeErrorNombre > 15 ? 'error-alto' : '') }}">
                                    <td>{{ $moduloPorNombre[$nombre] }}</td>
                                    <td>{{ $operacionesPorNombre[$nombre] }}</td>
                                    <td>{{ $teamLeaderPorNombre[$nombre] }}</td>
                                    <td>{{ number_format($porcentajeErrorNombre, 2) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-bordered table1">
                        <thead class="thead-custom3 text-center">
                            <tr>
                                <th>Jefes de Produccion</th> 
                                <th>% Error</th>
                                <!-- Aquí puedes agregar más encabezados si es necesario -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($porcentajesErrorJefeProduccion as $jefeProduccion => $porcentajeError)
                                <tr class="{{ ($porcentajeError > 10 && $porcentajeError <= 15) ? 'error-bajo' : ($porcentajeError > 15 ? 'error-alto' : '') }}">
                                    <td>{{ $jefeProduccion }}</td>
                                    <td>{{ number_format($porcentajeError, 2) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <table class="table table-bordered table1">
                        <thead class="thead-custom3 text-center">
                            <tr>
                                <th>Team Leader</th> 
                                <th>% Error</th>
                                <!-- Aquí puedes agregar más encabezados si es necesario -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($porcentajesErrorTeamLeader as $teamLeader => $porcentajeError)
                                <tr class="{{ ($porcentajeError > 10 && $porcentajeError <= 15) ? 'error-bajo' : ($porcentajeError > 15 ? 'error-alto' : '') }}">
                                    <td>{{ $teamLeader }}</td>
                                    <td>{{ number_format($porcentajeError, 2) }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table1 {
            max-width: 400px; /* Ajusta el valor según tus necesidades */
        }

        /* Personalizar estilo del thead */
        .thead-custom1 {
            background-color: #0c6666; /* Ajusta el color hexadecimal a tu gusto */
            color: #fff; /* Ajusta el color del texto si es necesario */
            border: 1px solid #ddd; /* Ajusta el borde si es necesario */
            padding: 10px; /* Ajusta el relleno si es necesario */
        }

        /* Personalizar estilo del thead */
        .thead-custom2 {
            background-color: #0891ec; /* Ajusta el color hexadecimal a tu gusto */
            color: #fff; /* Ajusta el color del texto si es necesario */
            border: 1px solid #ddd; /* Ajusta el borde si es necesario */
            padding: 10px; /* Ajusta el relleno si es necesario */
        }

        /* Personalizar estilo del thead */
        .thead-custom3 {
            background-color: #f77b07; /* Ajusta el color hexadecimal a tu gusto */
            color: #fff; /* Ajusta el color del texto si es necesario */
            border: 1px solid #ddd; /* Ajusta el borde si es necesario */
            padding: 10px; /* Ajusta el relleno si es necesario */
        }


        .error-bajo {
            background-color: #f8d7da; /* Rojo claro */
            color: #721c24; /* Texto oscuro */
        }

        .error-alto {
            background-color: #dc3545; /* Rojo */
            color: #ffffff; /* Texto blanco */
        }
    </style>


@endsection
