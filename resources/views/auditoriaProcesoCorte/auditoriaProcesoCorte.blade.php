@extends('layouts.app', ['activePage' => 'Proceso Corte', 'titlePage' => __('Proceso Corte')])

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
                                        <th>MESA</th>
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
                                                title="Por favor, selecciona una opción" onchange="evitarDuplicados(this, document.getElementById('nombre_2'))">
                                                <option value="">Selecciona una opción</option>
                                                @foreach ($CategoriaTecnico as $nombre)
                                                    <option value="{{ $nombre->nombre }}">{{ $nombre->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </td> 
                                        <td> 
                                            <select name="nombre_2" id="nombre_2" class="form-control" required
                                                title="Por favor, selecciona una opción"  onchange="evitarDuplicados(this, document.getElementById('nombre_1'))">
                                                <option value="">Selecciona una opción</option>
                                                @foreach ($CategoriaTecnico as $nombre2)
                                                    <option value="{{ $nombre2->nombre }}">{{ $nombre2->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </td> 
                                        <td>
                                            <select name="operacion" id="operacion" class="form-control" title="Por favor, selecciona una opción" required onchange="guardarSeleccion('operacion')"> 
                                                <option value="Tendedor Electrico">Tendedor Electrico</option>
                                                <option value="Tendedor Manual">Tendedor Manual</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="mesa" id="mesa" class="form-control" title="Por favor, selecciona una opción" required onchange="guardarSeleccion('mesa')">
                                                <option value="">Selecciona una opción</option>
                                                <option value="1 : Mesa">1 : Manual</option>
                                                <option value="2 : Brio">2 : Brio</option>
                                                <option value="3 : Brio">3 : Brio</option>
                                                <option value="4 : Brio">4 : Brio</option>
                                                <option value="5 : Brio">5 : Brio</option>
                                                <option value="6 : Brio">6 : Brio</option>
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
                    <hr>
                    <!--Desde aqui inicia la edicion del codigo para mostrar el contenido-->
                    @if($mostrarRegistro)
                        <div class="table-responsive"> 
                            <h2>Registro</h2>  
                            <table class="table"> 
                                <thead class="thead-primary"> 
                                    <tr> 
                                        <th>Nombre 1</th> 
                                        <th>Nombre 2</th>  
                                        <th>operacion</th>  
                                        <th>mesa</th>  
                                        <th>Lienzo tendido</th> 
                                        <th>Lienzo rechazado</th> 
                                        <th>T. P. </th>  
                                        <th>Accion Correctiva </th>  
                                    </tr> 
                                </thead>  
                                <tbody> 
                                    @foreach($mostrarRegistro as $registro) 
                                    <tr> 
                                        <td>{{ $registro->nombre_1 }}</td> 
                                        <td>{{ $registro->nombre_2 }}</td> 
                                        <td>{{ $registro->operacion }}</td> 
                                        <td>{{ $registro->mesa }}</td> 
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
    </style>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Seleccione una opción',
                allowClear: true
            });
        });
    </script>

    <script>
        // Función para guardar la selección actual en el almacenamiento local
        function guardarSeleccion(idSelect) {
            var select = document.getElementById(idSelect);
            var valorSeleccionado = select.options[select.selectedIndex].value;
            localStorage.setItem(idSelect, valorSeleccionado);
        }

        // Función para restaurar la selección desde el almacenamiento local
        function restaurarSeleccion(idSelect) {
            var valorGuardado = localStorage.getItem(idSelect);
            if (valorGuardado) {
                document.getElementById(idSelect).value = valorGuardado;
            }
        }

        // Ejecutar la función restaurarSeleccion al cargar la página
        window.onload = function() {
            restaurarSeleccion('nombre_1');
            restaurarSeleccion('nombre_2');
            restaurarSeleccion('operacion');
            restaurarSeleccion('mesa');
        }
    </script>

    <script>
        function evitarDuplicados(select1, select2) {
            const optionSeleccionada = select1.value;
            // Filtra las opciones del segundo select para eliminar la opción seleccionada en el primero
            const opcionesFiltradas = Array.from(select2.options).filter(
                (option) => option.value !== optionSeleccionada
            );
            // Limpia las opciones del segundo select
            select2.innerHTML = "";
            // Agrega las opciones filtradas al segundo select
            opcionesFiltradas.forEach((option) => select2.appendChild(option));

            // Llama a la función `guardarSeleccion` para el primer select
            guardarSeleccion(select1.id);

            // Llama a la función `guardarSeleccion` para el segundo select
            guardarSeleccion(select2.id);
        }
    </script>



@endsection
