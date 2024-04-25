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
                    <form method="POST" action="{{ route('auditoriaAQL.formRegistroAuditoriaProceso') }}">
                        @csrf
                        <input type="hidden" class="form-control" name="area" id="area"
                            value="{{ $data['area'] }}">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-primary">
                                    <tr>
                                        <th>MODULO</th>
                                        <th>OP</th>
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
                                            <th>ESTILO</th>
                                            <th>COLOR</th>
                                            <th>TALLA</th>
                                            <th># BULTO</th>
                                            <th>PIEZAS INSPECCIONADAS</th>
                                            <th>PIEZAS RECHAZADAS</th>
                                            <th>TIPO DE DEFECTO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="estilo" id="estilo"
                                                value="{{$datoUnicoOP->estilo}}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" name="color" id="color"
                                                value="{{$datoUnicoOP->colorname}}" readonly>
                                            </td>
                                            <td>
                                                <select name="talla" id="talla" class="form-control" required
                                                    title="Por favor, selecciona una opción">
                                                    <option value="">Selecciona una opción</option>
                                                    @foreach ($datoOP as $op)
                                                        <option value="{{ $op->sizename }}">{{ $op->sizename }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" name="bulto" id="bulto"
                                                    required></td>
                                            <td><input type="text" class="form-control" name="cantidad_auditada"
                                                    id="cantidad_auditada" required></td>
                                            <td><input type="text" class="form-control" name="cantidad_rechazada"
                                                    id="cantidad_rechazada" required></td>
                                            <td>
                                                <select name="tp" id="tp" class="form-control" required
                                                    title="Por favor, selecciona una opción">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="NINGUNO">NINGUNO</option>
                                                    @if ($data['area'] == 'AUDITORIA AQL')
                                                        @foreach ($categoriaTPProceso as $proceso)
                                                            <option value="{{ $proceso->nombre }}">{{ $proceso->nombre }}
                                                            </option>
                                                        @endforeach
                                                    @elseif($data['area'] == 'AUDITORIA AQL PLAYERA')
                                                        @foreach ($categoriaTPPlayera as $playera)
                                                            <option value="{{ $playera->nombre }}">{{ $playera->nombre }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="submit" class="btn btn-success">Añadir</button>
                        @endif
                    </form>
                    <hr>
                    <!--Desde aqui inicia la edicion del codigo para mostrar el contenido-->
                    @if ($mostrarRegistro)
                        @if ($estatusFinalizar)
                            <h2>Registro</h2>
                            <table class="table">
                                <thead class="thead-primary">
                                    <tr>
                                        <th>Operacion </th>
                                        <th>Lienzo tendido</th>
                                        <th>Lienzo rechazado</th>
                                        <th>T. P. </th>
                                        <th>Accion Correctiva </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mostrarRegistro as $registro)
                                        <tr>
                                            <form action="{{ route('auditoriaAQL.formUpdateDeleteProceso') }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $registro->id }}">
                                                <td>
                                                    <input type="text" class="form-control" name="operacion"
                                                        value="{{ $registro->operacion }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="cantidad_auditada"
                                                        value="{{ $registro->cantidad_auditada }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="cantidad_rechazada"
                                                        value="{{ $registro->cantidad_rechazada }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="tp"
                                                        value="{{ $registro->tp }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="ac"
                                                        value="{{ $registro->ac }}" readonly>
                                                </td>
                                                @if ($data['area'] == 'AUDITORIA EN EMPAQUE')
                                                @else
                                                    <td>
                                                        <input type="text" class="form-control" name="pxp"
                                                            value="{{ $registro->pxp }}" readonly>

                                                    </td>
                                                @endif
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

                                <table class="table">
                                    <thead class="thead-primary">
                                        <tr>
                                            <th>ESTILO</th>
                                            <th>COLOR</th>
                                            <th>TALLA</th>
                                            <th># BULTO</th>
                                            <th>PIEZAS INSPECCIONADAS</th>
                                            <th>PIEZAS RECHAZADAS</th>
                                            <th>TIPO DE DEFECTO</th>
                                            <th>GUARDAR </th>
                                            <th>Eliminar </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mostrarRegistro as $registro)
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" name="estilo" id="estilo"
                                                    value="{{$registro->estilo}}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="color" id="color"
                                                    value="{{$registro->color}}" readonly>
                                                </td>
                                                <form action="{{ route('auditoriaAQL.formUpdateDeleteProceso') }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $registro->id }}">

                                                    <td>
                                                        <select name="talla" id="talla" class="form-control"
                                                            required title="Por favor, selecciona una opción">
                                                            @foreach ($datoOP as $proceso)
                                                                <option value="{{ $proceso->sizename }}"
                                                                    {{ $registro->talla == $proceso->sizename ? 'selected' : '' }}>
                                                                    {{ $proceso->sizename }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="bulto_text"
                                                            id="bulto_text_{{ $registro->id }}"
                                                            value="{{ $registro->bulto }}" required>
                                                        <input type="hidden" name="bulto"
                                                            id="bulto_hidden_{{ $registro->id }}"
                                                            value="{{ $registro->bulto }}">
                                                    </td>
                                                    <script>
                                                        document.getElementById('bulto_text_{{ $registro->id }}').addEventListener('input', function() {
                                                            console.log('Input cambiado. Nuevo valor:', this.value);
                                                            document.getElementById('bulto_hidden_{{ $registro->id }}').value = this.value;
                                                            console.log('Campo oculto actualizado. Nuevo valor:', document.getElementById(
                                                                'bulto_hidden_{{ $registro->id }}').value);
                                                        });

                                                        // Actualizar el campo oculto al cargar la página
                                                        document.addEventListener('DOMContentLoaded', function() {
                                                            console.log('Página cargada. Valor actual:', document.getElementById(
                                                                'bulto_hidden_{{ $registro->id }}').value);
                                                            document.getElementById('bulto_hidden_{{ $registro->id }}').value = document.getElementById(
                                                                'bulto_text_{{ $registro->id }}').value;
                                                            console.log('Campo oculto actualizado al valor inicial:', document.getElementById(
                                                                'bulto_hidden_{{ $registro->id }}').value);
                                                        });
                                                    </script>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="cantidad_auditada_text"
                                                            id="cantidad_auditada_text_{{ $registro->id }}"
                                                            value="{{ $registro->cantidad_auditada }}" required>
                                                        <input type="hidden" name="cantidad_auditada"
                                                            id="cantidad_auditada_hidden_{{ $registro->id }}"
                                                            value="{{ $registro->cantidad_auditada }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="cantidad_rechazada_text"
                                                            id="cantidad_rechazada_text_{{ $registro->id }}"
                                                            value="{{ $registro->cantidad_rechazada }}" required>
                                                        <input type="hidden" name="cantidad_rechazada"
                                                            id="cantidad_rechazada_hidden_{{ $registro->id }}"
                                                            value="{{ $registro->cantidad_rechazada }}">
                                                    </td>
                                                    <script>
                                                        document.getElementById('cantidad_auditada_text_{{ $registro->id }}').addEventListener('input', function() {
                                                            document.getElementById('cantidad_auditada_hidden_{{ $registro->id }}').value = this.value;
                                                        });
                                                        document.getElementById('cantidad_rechazada_text_{{ $registro->id }}').addEventListener('input', function() {
                                                            document.getElementById('cantidad_rechazada_hidden_{{ $registro->id }}').value = this.value;
                                                        });
                                                    </script>
                                                    <td>
                                                        <select name="tp" id="tp" class="form-control"
                                                            required title="Por favor, selecciona una opción">
                                                            <option value="NINGUNO">NINGUNO</option>
                                                            @if ($data['area'] == 'AUDITORIA AQL')
                                                                @foreach ($categoriaTPProceso as $proceso)
                                                                    <option value="{{ $proceso->nombre }}"
                                                                        {{ $registro->tp == $proceso->nombre ? 'selected' : '' }}>
                                                                        {{ $proceso->nombre }}
                                                                    </option>
                                                                @endforeach
                                                            @elseif($data['area'] == 'AUDITORIA AQL PLAYERA')
                                                                @foreach ($categoriaTPPlayera as $playera)
                                                                    <option value="{{ $playera->nombre }}"
                                                                        {{ $registro->tp == $playera->nombre ? 'selected' : '' }}>
                                                                        {{ $playera->nombre }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button type="submit" name="action" value="update"
                                                            class="btn btn-success">Guardar</button>
                                                    </td>
                                                    <td>
                                                        <button type="submit" name="action" value="delete"
                                                            class="btn btn-danger">Eliminar</button>
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
                        <h2>Total Individual</h2>
                        <table class="table">
                            <thead class="thead-primary">
                                <tr>
                                    <th>Nombre </th>
                                    <th>Total Auditada</th>
                                    <th>Total Rechazada</th>
                                    <th>Porcentaje Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registrosIndividual as $registro)
                                    <tr>
                                        <td><input type="text" class="form-control" value="{{ $registro->nombre }}"
                                                readonly></td>
                                        <td><input type="text" class="form-control"
                                                value="{{ $registro->total_auditada }}" readonly></td>
                                        <td><input type="text" class="form-control"
                                                value="{{ $registro->total_rechazada }}" readonly></td>
                                        <td><input type="text" class="form-control"
                                                value="{{ $registro->total_rechazada != 0 ? round(($registro->total_rechazada / $registro->total_auditada) * 100, 2) : 0 }}"
                                                readonly></td>
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
                                    <td><input type="text" class="form-control" name="total_auditada"
                                            id="total_auditada" value="{{ $total_auditada }}" readonly></td>
                                    <td><input type="text" class="form-control" name="total_rechazada"
                                            id="total_rechazada" value="{{ $total_rechazada }}" readonly></td>
                                    <td><input type="text" class="form-control" name="total_porcentaje"
                                            id="total_porcentaje" value="{{ number_format($total_porcentaje, 2) }}"
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
            min-width: 200px;
            /* Ajusta el ancho mínimo según tu necesidad */
        }

        .table23 th:nth-child(5) {
            min-width: 200px;
            /* Ajusta el ancho mínimo según tu necesidad */
        }

        .table23 th:nth-child(6) {
            min-width: 200px;
            /* Ajusta el ancho mínimo según tu necesidad */
        }

        .table23 th:nth-child(7) {
            min-width: 70px;
            /* Ajusta el ancho mínimo según tu necesidad */
        }

        @media (max-width: 768px) {
            .table23 th:nth-child(3) {
                min-width: 100px;
                /* Ajusta el ancho mínimo para móviles */
            }
        }
    </style>



@endsection
