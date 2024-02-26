@extends('layouts.app', ['activePage' => 'Corte', 'titlePage' => __('Corte')])

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
                    <h3 class="card-title">CONTROL DE CALIDAD EN CORTE</h3>
                    {{--<h3 id="estatusValue2">Estatus: {{ $datoAX->estatus }}</h3>--}}
                    @isset($encabezadoAuditoriaCorte->estatus)
                        <h3 id="estatusValue">Estatus: {{ $encabezadoAuditoriaCorte->estatus }}</h3>
                    @endisset
                    @if($datoAX->evento == NULL || $datoAX->evento == '')

                    @else
                    <h4>Evento: {{$auditoriaMarcada->evento}} / {{ $datoAX->evento }} </h4>
                    @endif
                </div>
                <hr> 
                @if ($encabezadoAuditoriaCorte && $encabezadoAuditoriaCorte->estatus == "proceso")
                <form method="POST" action="{{ route('auditoriaCorte.formEncabezadoAuditoriaCorte') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $datoAX->id }}">
                    <input type="hidden" name="orden" value="{{ $datoAX->op }}">
                    <input type="hidden" name="idEncabezadoAuditoriaCorte" value="{{ $encabezadoAuditoriaCorte->id }}">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <h4>Orden: {{ $datoAX->op }}</h4>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <h4>Estilo: {{ $datoAX->estilo }}</h4>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <h4>Temporada: {{ $datoAX->temporada }}</h4>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <h4>Cliente: {{ isset($encabezadoAuditoriaCorte) ? $encabezadoAuditoriaCorte->cliente : '' }}</h4>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <h4>Material: {{ isset($encabezadoAuditoriaCorte) ? $encabezadoAuditoriaCorte->material : '' }}</h4>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <h4>Color: {{ isset($encabezadoAuditoriaCorte) ? $encabezadoAuditoriaCorte->color : '' }}</h4>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                            <label for="pieza" class="col-sm-6 col-form-label">PIEZAS</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" name="pieza" id="pieza"
                                    placeholder="..." required/>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                            <label for="lienzo" class="col-sm-6 col-form-label">LIENZOS</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="lienzo" id="lienzo"
                                    placeholder="..." required/>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
                @elseif($encabezadoAuditoriaCorte && ($encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaMarcada' || $encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaTendido' || $encabezadoAuditoriaCorte->estatus == 'estatusLectra' || $encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaBulto' || $encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaFinal' || $encabezadoAuditoriaCorte->estatus == 'fin'))
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <h4>Orden: {{ $datoAX->op }}</h4>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <h4>Estilo: {{ $datoAX->estilo }}</h4>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <h4>Temporada: {{ $datoAX->temporada }}</h4>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <h4>Cliente: {{ isset($encabezadoAuditoriaCorte) ? $encabezadoAuditoriaCorte->cliente : '' }}</h4>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <h4>Material: {{ isset($encabezadoAuditoriaCorte) ? $encabezadoAuditoriaCorte->material : '' }}</h4>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <h4>Color: {{ isset($encabezadoAuditoriaCorte) ? $encabezadoAuditoriaCorte->color : '' }}</h4>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <h4>Lienzo: {{ isset($encabezadoAuditoriaCorte) ? $encabezadoAuditoriaCorte->lienzo : '' }}</h4>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <h4>Piezas: {{ isset($encabezadoAuditoriaCorte) ? $encabezadoAuditoriaCorte->pieza : '' }}</h4>
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <h4>Orden: {{ $datoAX->op }}</h4>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <h4>Estlo: {{ $datoAX->estilo }}</h4>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <h4>Planta: {{ $datoAX->planta }}</h4>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <h4>Temporada: {{ $datoAX->temporada }}</h4>
                    </div>
                </div>
                <form method="POST" action="{{ route('auditoriaCorte.formEncabezadoAuditoriaCorte') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $datoAX->id }}">
                    <input type="hidden" name="orden" value="{{ $datoAX->op }}">
                    <!-- Desde aquí inicia la edición del código para mostrar el contenido -->
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                            <label for="cliente" class="col-sm-6 col-form-label">Cliente</label>
                            <div class="col-sm-12 d-flex align-items-center">
                                <select name="cliente" id="cliente" class="form-control"
                                    title="Por favor, selecciona una opción" required>
                                    <option value="">Selecciona una opción</option>
                                    @foreach ($CategoriaCliente as $cliente)
                                        <option value="{{ $cliente->nombre }}">{{ $cliente->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                            <label for="color" class="col-sm-6 col-form-label">Color</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="color" id="color"
                                    placeholder="codigo del color" required/>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                            <label for="material" class="col-sm-6 col-form-label">Material</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="material" id="material"
                                    placeholder="nombre del material" required/>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                            <label for="evento" class="col-sm-9 col-form-label">CANTIDAD EVENTOS</label>
                            <div class="col-sm-12">
                                <select class="form-control" name="evento" id="evento" required>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        {{-- 
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                            <label for="trazo" class="col-sm-6 col-form-label">TRAZO</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" name="trazo" id="trazo"
                                    placeholder="..." required/>
                            </div>
                        </div>
                        --}}
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                            <label for="pieza" class="col-sm-6 col-form-label">PIEZAS</label>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" name="pieza" id="pieza"
                                    placeholder="..." required/>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-3">
                            <label for="lienzo" class="col-sm-6 col-form-label">LIENZOS</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="lienzo" id="lienzo"
                                    placeholder="..." required/>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
                @endif
                <div id="accordion">
                    <!--Inicio acordeon 1 -->
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button id="btnOne" class="btn btn-info btn-block" data-toggle="collapse" data-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    - - AUDITORIA DE MARCADA - -
                                </button>
                            </h5>
                        </div>
                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                {{-- Inicio cuerpo acordeon --}}
                                @if($encabezadoAuditoriaCorte && $encabezadoAuditoriaCorte->estatus == 'proceso')
                                    <p> - </p>
                                @elseif ($encabezadoAuditoriaCorte && $encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaMarcada') 
                                <form method="POST"
                                    action="{{ route('auditoriaCorte.formAuditoriaMarcada', ['id' => $datoAX->id]) }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $datoAX->id }}">
                                    <input type="hidden" name="idAuditoriaMarcada" value="{{ $auditoriaMarcada->id }}">
                                    <input type="hidden" name="orden" value="{{ $datoAX->orden }}">
                                    {{-- Campo oculto para el boton Finalizar --}}
                                    <input type="hidden" name="accion" value="">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="yarda_orden" class="col-sm-6 col-form-label">Yardas en la
                                                orden</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <div class="form-check form-check-inline">
                                                    <input type="number" step="0.0001" class="form-control me-2"
                                                        name="yarda_orden" id="yarda_orden" placeholder="..."
                                                        value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->yarda_orden : '' }}"
                                                        required />
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio" name="yarda_orden_estatus"
                                                        id="yarda_orden_estatus1" value="1"
                                                        {{ isset($auditoriaMarcada) && $auditoriaMarcada->yarda_orden_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="yarda_orden_estatus1">✔ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio" name="yarda_orden_estatus"
                                                        id="yarda_orden_estatus2" value="0"
                                                        {{ isset($auditoriaMarcada) && $auditoriaMarcada->yarda_orden_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="yarda_orden_estatus2">✖ </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="yarda_marcada" class="col-sm-6 col-form-label">Yardas en la
                                                marcada</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <div class="form-check form-check-inline">
                                                    <input type="number" step="0.0001" class="form-control me-2"
                                                        name="yarda_marcada" id="yarda_marcada" placeholder="..."
                                                        value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->yarda_marcada : '' }}"
                                                        required />
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="yarda_marcada_estatus" id="yarda_marcada_estatus1"
                                                        value="1"
                                                        {{ isset($auditoriaMarcada) && $auditoriaMarcada->yarda_marcada_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="yarda_marcada_estatus1">✔ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="yarda_marcada_estatus" id="yarda_marcada_estatus2"
                                                        value="0"
                                                        {{ isset($auditoriaMarcada) && $auditoriaMarcada->yarda_marcada_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="yarda_marcada_estatus2">✖ </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="yarda_tendido" class="col-sm-6 col-form-label">Yardas en el
                                                tendido</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <div class="form-check form-check-inline">
                                                    <input type="number" step="0.0001" class="form-control me-2"
                                                        name="yarda_tendido" id="yarda_tendido" placeholder="..."
                                                        value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->yarda_tendido : '' }}"
                                                        required />
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="yarda_tendido_estatus" id="yarda_tendido_estatus1"
                                                        value="1"
                                                        {{ isset($auditoriaMarcada) && $auditoriaMarcada->yarda_tendido_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="yarda_tendido_estatus1">✔ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="yarda_tendido_estatus" id="yarda_tendido_estatus2"
                                                        value="0"
                                                        {{ isset($auditoriaMarcada) && $auditoriaMarcada->yarda_tendido_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="yarda_tendido_estatus2">✖ </label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        {{-- 
                                        <div class="col-md-6 mb-3">
                                            <label for="pieza_bulto" class="col-sm-3 col-form-label">Piezas X Bulto </label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="number" step="0.0001" class="form-control me-2" name="pieza_bulto" id="pieza_bulto"
                                                    placeholder="..." />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="pieza_total" class="col-sm-3 col-form-label">Piezas Totales</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="number" step="0.0001" class="form-control me-2" name="pieza_total" id="pieza_total"
                                                    placeholder="..." />
                                            </div>
                                        </div>
                                        --}}
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="talla1" class="col-sm-3 col-form-label">Tallas</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="text" class="form-control me-2"
                                                    name="talla1" id="talla1" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->talla1 : '' }}"
                                                    required />
                                                <input type="text" class="form-control me-2"
                                                    name="talla2" id="talla2" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->talla2 : '' }}" />
                                                <input type="text" class="form-control me-2"
                                                    name="talla3" id="talla3" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->talla3 : '' }}" />
                                                <input type="text" class="form-control me-2"
                                                    name="talla4" id="talla4" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->talla4 : '' }}" />
                                                <input type="text" class="form-control me-2"
                                                    name="talla5" id="talla5" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->talla5 : '' }}" />
                                            </div>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="text" class="form-control me-2"
                                                    name="talla6" id="talla6" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->talla6 : '' }}" />
                                                <input type="text" class="form-control me-2"
                                                    name="talla7" id="talla7" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->talla7 : '' }}" />
                                                <input type="text" class="form-control me-2"
                                                    name="talla8" id="talla8" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->talla8 : '' }}" />
                                                <input type="text" class="form-control me-2"
                                                    name="talla9" id="talla9" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->talla9 : '' }}" />
                                                <input type="text" class="form-control me-2"
                                                    name="talla10" id="talla10" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->talla10 : '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="bulto1" class="col-sm-3 col-form-label"># Bultos</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="bulto1" id="bulto1" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->bulto1 : '' }}"
                                                    required />
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="bulto2" id="bulto2" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->bulto2 : '' }}" />
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="bulto3" id="bulto3" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->bulto3 : '' }}" />
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="bulto4" id="bulto4" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->bulto4 : '' }}" />
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="bulto5" id="bulto5" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->bulto5 : '' }}" />
                                            </div>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="bulto6" id="bulto6" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->bulto6 : '' }}" />
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="bulto7" id="bulto7" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->bulto7 : '' }}" />
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="bulto8" id="bulto8" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->bulto8 : '' }}" />
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="bulto9" id="bulto9" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->bulto9 : '' }}" />
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="bulto10" id="bulto10" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->bulto10 : '' }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="total_pieza1" class="col-sm-3 col-form-label">Total piezas</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="total_pieza1" id="total_pieza1" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->total_pieza1 : '' }}"
                                                    required />
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="total_pieza2" id="total_pieza2" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->total_pieza2 : '' }}" />
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="total_pieza3" id="total_pieza3" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->total_pieza3 : '' }}" />
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="total_pieza4" id="total_pieza4" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->total_pieza4 : '' }}" />
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="total_pieza5" id="total_pieza5" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->total_pieza4 : '' }}" />
                                            </div>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="total_pieza6" id="total_pieza6" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->total_pieza6 : '' }}" />
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="total_pieza7" id="total_pieza7" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->total_pieza7 : '' }}" />
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="total_pieza8" id="total_pieza8" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->total_pieza8 : '' }}" />
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="total_pieza9" id="total_pieza9" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->total_pieza9 : '' }}" />
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="total_pieza10" id="total_pieza10" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->total_pieza10 : '' }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="largo_trazo" class="col-sm-3 col-form-label">Largo Trazo </label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="largo_trazo" id="largo_trazo" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->largo_trazo : '' }}"
                                                    required />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="ancho_trazo" class="col-sm-3 col-form-label">Ancho Trazo </label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="ancho_trazo" id="ancho_trazo" placeholder="..."
                                                    value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->ancho_trazo : '' }}"
                                                    required />
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" name="accion" class="btn btn-success">Guardar</button>
                                        @if($mostrarFinalizarMarcada)
                                            <button type="submit" class="btn btn-danger" value="finalizar" name="accion" >Finalizar</button>
                                        @else
                                            <button type="submit" class="btn btn-danger" disabled>Finalizar</button>
                                        @endif
                                    </div>
                                </form>
                                {{-- Fin cuerpo acordeon --}}
                                @elseif($encabezadoAuditoriaCorte && ($encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaMarcada' || $encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaTendido' || $encabezadoAuditoriaCorte->estatus == 'estatusLectra' || $encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaBulto' || $encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaFinal' || $encabezadoAuditoriaCorte->estatus == 'fin'))  
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="yarda_orden" class="col-sm-6 col-form-label">Yardas en la
                                            orden</label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <div class="form-check form-check-inline">
                                                <h4>{{ isset($auditoriaMarcada) ? $auditoriaMarcada->yarda_orden : '' }}</h4>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                @if(isset($auditoriaMarcada) && $auditoriaMarcada->yarda_orden_estatus == 1)
                                                    <label class="label-paloma" for="yarda_orden_estatus1">✔</label>
                                                @elseif(isset($auditoriaMarcada) && $auditoriaMarcada->yarda_orden_estatus == 0)
                                                    <label class="label-tache" for="yarda_orden_estatus2">✖</label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="yarda_marcada" class="col-sm-6 col-form-label">Yardas en la
                                            marcada</label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <div class="form-check form-check-inline">
                                                <h4>{{ isset($auditoriaMarcada) ? $auditoriaMarcada->yarda_marcada : '' }}</h4>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                @if(isset($auditoriaMarcada) && $auditoriaMarcada->yarda_marcada_estatus == 1)
                                                    <label class="label-paloma" for="yarda_orden_estatus1">✔</label>
                                                @elseif(isset($auditoriaMarcada) && $auditoriaMarcada->yarda_marcada_estatus == 0)
                                                    <label class="label-tache" for="yarda_orden_estatus2">✖</label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="yarda_tendido" class="col-sm-6 col-form-label">Yardas en el
                                            tendido</label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <div class="form-check form-check-inline">
                                                <h4>{{ isset($auditoriaMarcada) ? $auditoriaMarcada->yarda_tendido : '' }}</h4>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                @if(isset($auditoriaMarcada) && $auditoriaMarcada->yarda_tendido_estatus == 1)
                                                    <label class="label-paloma" for="yarda_orden_estatus1">✔</label>
                                                @elseif(isset($auditoriaMarcada) && $auditoriaMarcada->yarda_tendido_estatus == 0)
                                                    <label class="label-tache" for="yarda_orden_estatus2">✖</label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="talla1" class="col-sm-3 col-form-label">Tallas</label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            @php
                                            $total_tallas1 = [
                                                $auditoriaMarcada->talla1 ?? '',
                                                $auditoriaMarcada->talla2 ?? '',
                                                $auditoriaMarcada->talla3 ?? '',
                                                $auditoriaMarcada->talla4 ?? '',
                                                $auditoriaMarcada->talla5 ?? '',
                                            ];
                                            @endphp
                                            <input type="text" readonly value="{{ implode(' - ', array_filter($total_tallas1)) }}" class="form-control">
                                        </div>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            @php
                                            $total_tallas2 = [
                                                $auditoriaMarcada->talla6 ?? '',
                                                $auditoriaMarcada->talla7 ?? '',
                                                $auditoriaMarcada->talla8 ?? '',
                                                $auditoriaMarcada->talla9 ?? '',
                                                $auditoriaMarcada->talla10 ?? '',
                                            ];
                                            @endphp
                                            <input type="text" readonly value="{{ implode(' -- ', array_filter($total_tallas2)) }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="bulto1" class="col-sm-3 col-form-label"># Bultos</label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            @php
                                            $total_bultos1 = [
                                                $auditoriaMarcada->bulto1 ?? '',
                                                $auditoriaMarcada->bulto2 ?? '',
                                                $auditoriaMarcada->bulto3 ?? '',
                                                $auditoriaMarcada->bulto4 ?? '',
                                                $auditoriaMarcada->bulto5 ?? '',
                                            ];
                                            @endphp
                                            <input type="text" readonly value="{{ implode(' -- ', array_filter($total_bultos1)) }}" class="form-control">
                                        </div>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            @php
                                            $total_bultos2 = [
                                                $auditoriaMarcada->total_bulto1 ?? '',
                                                $auditoriaMarcada->total_bulto2 ?? '',
                                                $auditoriaMarcada->total_bulto3 ?? '',
                                                $auditoriaMarcada->total_bulto4 ?? '',
                                                $auditoriaMarcada->total_bulto5 ?? '',
                                            ];
                                            @endphp
                                            <input type="text" readonly value="{{ implode(' -- ', array_filter($total_bultos2)) }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="total_pieza1" class="col-sm-3 col-form-label">Total piezas</label>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            @php
                                            $total_piezas1 = [
                                                $auditoriaMarcada->total_pieza1 ?? '',
                                                $auditoriaMarcada->total_pieza2 ?? '',
                                                $auditoriaMarcada->total_pieza3 ?? '',
                                                $auditoriaMarcada->total_pieza4 ?? '',
                                                $auditoriaMarcada->total_pieza5 ?? '',
                                            ];
                                            @endphp
                                            <input type="text" readonly value="{{ implode(' -- ', array_filter($total_piezas1)) }}" class="form-control">
                                        </div>
                                        <div class="col-sm-6 d-flex align-items-center">
                                            @php
                                            $total_piezas2 = [
                                                $auditoriaMarcada->total_pieza6 ?? '',
                                                $auditoriaMarcada->total_pieza7 ?? '',
                                                $auditoriaMarcada->total_pieza8 ?? '',
                                                $auditoriaMarcada->total_pieza9 ?? '',
                                                $auditoriaMarcada->total_pieza10 ?? '',
                                            ];
                                            @endphp
                                            <input type="text" readonly value="{{ implode(' -- ', array_filter($total_piezas2)) }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="largo_trazo" class="col-sm-3 col-form-label">Largo Trazo </label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <input type="text" readonly value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->largo_trazo : '' }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="ancho_trazo" class="col-sm-3 col-form-label">Ancho Trazo </label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <input type="text" readonly value="{{ isset($auditoriaMarcada) ? $auditoriaMarcada->ancho_trazo : '' }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--Fin acordeon 1 -->
                    <!--Inicio acordeon 2 -->
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button id="btnTwo" class="btn btn-info btn-block collapsed" data-toggle="collapse"
                                    data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    - - AUDITORIA DE TENDIDO - -
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                {{-- Inicio cuerpo acordeon --}}
                                @if($encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaMarcada')
                                    <p>-</p>
                                @elseif ($encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaTendido')
                                <form method="POST"
                                    action="{{ route('auditoriaCorte.formAuditoriaTendido', ['id' => $datoAX->id]) }}"> 
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $datoAX->id }}">
                                    <input type="hidden" name="idAuditoriaTendido" value="{{ $auditoriaTendido->id }}">
                                    <input type="hidden" name="orden" value="{{ $datoAX->orden }}">
                                    {{-- Campo oculto para el boton Finalizar --}}
                                    <input type="hidden" name="accion" value="">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nombre" class="col-sm-6 col-form-label">NOMBRE TECNICO</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <select name="nombre" id="nombre" class="form-control"
                                                    title="Por favor, selecciona una opción" required>
                                                    <option value="">Selecciona una opción</option>
                                                    @foreach ($CategoriaTecnico as $nombre)
                                                        <option value="{{ $nombre->nombre }}"
                                                            {{ isset($auditoriaTendido) && trim($auditoriaTendido->nombre) === trim($nombre->nombre) ? 'selected' : '' }}>
                                                            {{ $nombre->nombre }}</option>
                                                    @endforeach
                                                </select>
                                                &nbsp;&nbsp;
                                                <select name="nombre2" id="nombre2" class="form-control"
                                                    title="Por favor, selecciona una opción">
                                                    <option value="">Selecciona una opción</option>
                                                    @foreach ($CategoriaTecnico as $nombre)
                                                        <option value="{{ $nombre->nombre }}"
                                                            {{ isset($auditoriaTendido) && trim($auditoriaTendido->nombre2) === trim($nombre->nombre) ? 'selected' : '' }}>
                                                            {{ $nombre->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="fecha" class="col-sm-6 col-form-label">Fecha</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                {{ now()->format('d ') . $mesesEnEspanol[now()->format('n') - 1] . now()->format(' Y') }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="mesa" class="col-sm-6 col-form-label">MESA</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <select name="mesa" id="mesa" class="form-control" title="Por favor, selecciona una opción" required>
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="1 : Mesa" {{ isset($auditoriaTendido) && $auditoriaTendido->mesa == '1 : Mesa' ? 'selected' : '' }}>1 : Manual</option>
                                                    <option value="2 : Brio" {{ isset($auditoriaTendido) && $auditoriaTendido->mesa == '2 : Brio' ? 'selected' : '' }}>2 : Brio</option>
                                                    <option value="3 : Brio" {{ isset($auditoriaTendido) && $auditoriaTendido->mesa == '3 : Brio' ? 'selected' : '' }}>3 : Brio</option>
                                                    <option value="4 : Brio" {{ isset($auditoriaTendido) && $auditoriaTendido->mesa == '4 : Brio' ? 'selected' : '' }}>4 : Brio</option>
                                                    <option value="5 : Brio" {{ isset($auditoriaTendido) && $auditoriaTendido->mesa == '5 : Brio' ? 'selected' : '' }}>5 : Brio</option>
                                                    <option value="6 : Brio" {{ isset($auditoriaTendido) && $auditoriaTendido->mesa == '6 : Brio' ? 'selected' : '' }}>6 : Brio</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="auditor" class="col-sm-6 col-form-label">AUDITOR</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="text" class="form-control me-2" name="auditor" id="auditor"
                                                    value="{{ $auditorDato }}" readonly required />
                                                <input type="hidden" name="auditor" value="{{ $auditorDato }}">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="codigo_material" class="col-sm-6 col-form-label">1. Codigo de
                                                material</label>
                                            <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="codigo_material_estatus" id="codigo_material_estatus1"
                                                        value="1"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->codigo_material_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="codigo_material_estatus1">✔ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="codigo_material_estatus" id="codigo_material_estatus2"
                                                        value="0"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->codigo_material_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="codigo_material_estatus2">✖ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="text" class="form-control me-2"
                                                        name="codigo_material" id="codigo_material" placeholder="..."
                                                        value="{{ isset($auditoriaTendido) ? $auditoriaTendido->codigo_material : '' }}"
                                                        required />
                                                </div>                                              
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="codigo_color" class="col-sm-6 col-form-label">2. Codigo de
                                                color</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <div class="col-sm-12 d-flex align-items-center"
                                                    style="margin-right: -5px;">
                                                    <div class="form-check form-check-inline">
                                                        <input class="quitar-espacio" type="radio"
                                                            name="codigo_color_estatus" id="codigo_color_estatus1"
                                                            value="1"
                                                            {{ isset($auditoriaTendido) && $auditoriaTendido->codigo_color_estatus == 1 ? 'checked' : '' }}
                                                            required />
                                                        <label class="label-paloma" for="codigo_color_estatus1">✔ </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="quitar-espacio" type="radio"
                                                            name="codigo_color_estatus" id="codigo_color_estatus2"
                                                            value="0"
                                                            {{ isset($auditoriaTendido) && $auditoriaTendido->codigo_color_estatus == 0 ? 'checked' : '' }}
                                                            required />
                                                        <label class="label-tache" for="codigo_color_estatus2">✖ </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="text" class="form-control me-2" name="codigo_color" id="codigo_color"
                                                               placeholder="..." value="{{ $encabezadoAuditoriaCorte->color }}" readonly required />
                                                        <input type="hidden" name="codigo_color" value="{{ $encabezadoAuditoriaCorte->color }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="informacion_trazo" class="col-sm-6 col-form-label">3. Informacion
                                                de trazo</label>
                                            <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="informacion_trazo_estatus" id="informacion_trazo_estatus1"
                                                        value="1"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->informacion_trazo_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="informacion_trazo_estatus1">✔
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="informacion_trazo_estatus" id="informacion_trazo_estatus2"
                                                        value="0"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->informacion_trazo_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="informacion_trazo_estatus2">✖ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <select name="informacion_trazo" id="informacion_trazo" class="form-control" title="Por favor, selecciona una opción">
                                                        <option value="">Selecciona una opción</option>
                                                        <option value="Si" {{ isset($auditoriaTendido) && $auditoriaTendido->informacion_trazo == 'Si' ? 'selected' : '' }}>Si</option>
                                                        <option value="No" {{ isset($auditoriaTendido) && $auditoriaTendido->informacion_trazo == 'No' ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="cantidad_lienzo" class="col-sm-6 col-form-label">4. Cantidad de
                                                lienzos</label>
                                            <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="cantidad_lienzo_estatus" id="cantidad_lienzo_estatus1"
                                                        value="1"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->cantidad_lienzo_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="cantidad_lienzo_estatus1">✔ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="cantidad_lienzo_estatus" id="cantidad_lienzo_estatus2"
                                                        value="0"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->cantidad_lienzo_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="cantidad_lienzo_estatus2">✖ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="text" class="form-control me-2" name="cantidad_lienzo" id="cantidad_lienzo"
                                                           value="{{ $encabezadoAuditoriaCorte->lienzo }}" readonly required />
                                                    <input type="hidden" name="cantidad_lienzo" value="{{ $encabezadoAuditoriaCorte->lienzo }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="longitud_tendido" class="col-sm-6 col-form-label">5. Longitud de
                                                tendido</label>
                                            <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="longitud_tendido_estatus" id="longitud_tendido_estatus1"
                                                        value="1"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->longitud_tendido_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="longitud_tendido_estatus1">✔ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="longitud_tendido_estatus" id="longitud_tendido_estatus2"
                                                        value="0"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->longitud_tendido_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="longitud_tendido_estatus2">✖ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="text" class="form-control me-2" name="longitud_tendido" id="longitud_tendido"
                                                           value="{{ $auditoriaMarcada->largo_trazo }}" readonly required />
                                                    <input type="hidden" name="longitud_tendido" value="{{ $auditoriaMarcada->largo_trazo }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="ancho_tendido" class="col-sm-6 col-form-label">6. Ancho de
                                                tendido</label>
                                            <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="ancho_tendido_estatus" id="ancho_tendido_estatus1"
                                                        value="1"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->ancho_tendido_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="ancho_tendido_estatus1">✔ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="ancho_tendido_estatus" id="ancho_tendido_estatus2"
                                                        value="0"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->ancho_tendido_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="ancho_tendido_estatus2">✖ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="text" class="form-control me-2" name="ancho_tendido" id="ancho_tendido"
                                                           value="{{ $auditoriaMarcada->ancho_trazo }}" readonly required />
                                                    <input type="hidden" name="ancho_tendido" value="{{ $auditoriaMarcada->ancho_trazo }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="material_relajado" class="col-sm-6 col-form-label">7. Material relajado</label>
                                            <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="material_relajado_estatus" id="material_relajado_estatus1"
                                                        value="1"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->material_relajado_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="material_relajado_estatus1">✔
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="material_relajado_estatus" id="material_relajado_estatus2"
                                                        value="0"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->material_relajado_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="material_relajado_estatus2">✖ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <select name="material_relajado" id="material_relajado" class="form-control"
                                                        title="Por favor, selecciona una opción">
                                                        <option value="">Selecciona una opción</option>
                                                        @foreach ($CategoriaMaterialRelajado as $materialRelajado)
                                                            <option value="{{ $materialRelajado->nombre }}"
                                                                {{ isset($auditoriaTendido) && trim($auditoriaTendido->material_relajado) == trim($materialRelajado->nombre) ? 'selected' : '' }}>
                                                                {{ $materialRelajado->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="empalme" class="col-sm-6 col-form-label">8. Empalmes</label>
                                            <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio" name="empalme_estatus"
                                                        id="empalme_estatus1" value="1"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->empalme_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="empalme_estatus1">✔ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio" name="empalme_estatus"
                                                        id="empalme_estatus2" value="0"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->empalme_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="empalme_estatus2">✖ </label>
                                                </div>
                                                {{-- 
                                                <div class="form-check form-check-inline">
                                                    <input type="number" step="0.0001" class="form-control me-2"
                                                        name="empalme" id="empalme" placeholder="..."
                                                        value="{{ isset($auditoriaTendido) ? $auditoriaTendido->empalme : '' }}"
                                                        required />
                                                </div>
                                                --}}
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="cara_material" class="col-sm-6 col-form-label">9. Cara de
                                                material</label>
                                            <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="cara_material_estatus" id="cara_material_estatus1"
                                                        value="1"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->cara_material_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="cara_material_estatus1">✔ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="cara_material_estatus" id="cara_material_estatus2"
                                                        value="0"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->cara_material_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="cara_material_estatus2">✖ </label>
                                                </div>
                                                {{--
                                                <div class="form-check form-check-inline">
                                                    <input type="number" step="0.0001" class="form-control me-2"
                                                        name="cara_material" id="cara_material" placeholder="..."
                                                        value="{{ isset($auditoriaTendido) ? $auditoriaTendido->cara_material : '' }}"
                                                        required />
                                                </div>
                                                --}}
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tono" class="col-sm-6 col-form-label">10. Tonos</label>
                                            <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio" name="tono_estatus"
                                                        id="tono_estatus1" value="1"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->tono_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="tono_estatus1">✔ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio" name="tono_estatus"
                                                        id="tono_estatus2" value="0"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->tono_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="tono_estatus2">✖ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="text" class="form-control me-2"
                                                        name="tono" id="tono" placeholder="..."
                                                        value="{{ isset($auditoriaTendido) ? $auditoriaTendido->tono : '' }}"
                                                        required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="alineacion_tendido" class="col-sm-6 col-form-label">11. Alineacion de tendido</label>
                                            <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                                {{--
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="alineacion_tendido_estatus" id="alineacion_tendido_estatus1"
                                                        value="1"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->alineacion_tendido_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="alineacion_tendido_estatus1">✔
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="alineacion_tendido_estatus" id="alineacion_tendido_estatus2"
                                                        value="0"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->alineacion_tendido_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="alineacion_tendido_estatus2">✖
                                                    </label>
                                                </div>
                                                --}}
                                                <div class="form-check form-check-inline">
                                                    <select name="alineacion_tendido" id="alineacion_tendido" class="form-control" title="Por favor, selecciona una opción">
                                                        <option value="">Selecciona una opción</option>
                                                        <option value="Regular" {{ isset($auditoriaTendido) && $auditoriaTendido->alineacion_tendido == 'Regular' ? 'selected' : '' }}>Regular </option>
                                                        <option value="Mal" {{ isset($auditoriaTendido) && $auditoriaTendido->alineacion_tendido == 'Mal' ? 'selected' : '' }}>Mal </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="arruga_tendido" class="col-sm-6 col-form-label">12. Arrugas de
                                                tendido</label>
                                            <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                                {{--
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="arruga_tendido_estatus" id="arruga_tendido_estatus1"
                                                        value="1"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->arruga_tendido_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="arruga_tendido_estatus1">✔ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="arruga_tendido_estatus" id="arruga_tendido_estatus2"
                                                        value="0"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->arruga_tendido_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="arruga_tendido_estatus2">✖ </label>
                                                </div>
                                                --}}
                                                <div class="form-check form-check-inline">
                                                    <select name="arruga_tendido" id="arruga_tendido" class="form-control" title="Por favor, selecciona una opción">
                                                        <option value="">Selecciona una opción</option>
                                                        <option value="Algunas" {{ isset($auditoriaTendido) && $auditoriaTendido->arruga_tendido == 'Algunas' ? 'selected' : '' }}>Algunas </option>
                                                        <option value="Pocas" {{ isset($auditoriaTendido) && $auditoriaTendido->arruga_tendido == 'Pocas' ? 'selected' : '' }}>Pocas </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="defecto_material" class="col-sm-6 col-form-label">13. defecto de
                                                material</label>
                                            <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                                {{--
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="defecto_material_estatus" id="defecto_material_estatus1"
                                                        value="1"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->defecto_material_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="defecto_material_estatus1">✔ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="defecto_material_estatus" id="defecto_material_estatus2"
                                                        value="0"
                                                        {{ isset($auditoriaTendido) && $auditoriaTendido->defecto_material_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="defecto_material_estatus2">✖ </label>
                                                </div>
                                                --}}
                                                <div class="form-check form-check-inline">
                                                    <select name="defecto_material" id="defecto_material" class="form-control"
                                                    title="Por favor, selecciona una opción">
                                                    <option value="">Selecciona una opción</option>
                                                    @foreach ($CategoriaDefecto as $defectoMaterial)
                                                        <option value="{{ $defectoMaterial->nombre }}"
                                                            {{ isset($auditoriaTendido) && trim($auditoriaTendido->defecto_material) == trim($defectoMaterial->nombre) ? 'selected' : '' }}>
                                                            {{ $defectoMaterial->nombre }}</option>
                                                    @endforeach
                                                </select>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="accion_correctiva" class="col-sm-6 col-form-label">Accion
                                                correctiva </label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="text" class="form-control me-2" name="accion_correctiva"
                                                    id="accion_correctiva" placeholder="COMENTARIO"
                                                    value="{{ isset($auditoriaTendido) ? $auditoriaTendido->accion_correctiva : '' }}"
                                                    required />
                                            </div>
                                        </div>
                                        {{--
                                        <div class="col-md-6 mb-3">
                                            <label for="libera_tendido" class="col-sm-6 col-form-label">¿Se libera el
                                                tendido?</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="text" class="form-control me-2" name="libera_tendido"
                                                    id="libera_tendido" placeholder="..."
                                                    value="{{ isset($auditoriaTendido) ? $auditoriaTendido->libera_tendido : '' }}"
                                                    required />
                                            </div>
                                        </div>
                                        --}}
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        @if($mostrarFinalizarTendido)
                                            <button type="submit" class="btn btn-danger" value="finalizar" name="accion" >Finalizar</button>
                                        @else
                                            <button type="submit" class="btn btn-danger" disabled>Finalizar</button>
                                        @endif
                                    </div>
                                </form>
                                @elseif($encabezadoAuditoriaCorte && ($encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaMarcada' || $encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaTendido' || $encabezadoAuditoriaCorte->estatus == 'estatusLectra' || $encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaBulto' || $encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaFinal' || $encabezadoAuditoriaCorte->estatus == 'fin'))
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="col-sm-6 col-form-label">NOMBRE TECNICO</label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <input type="text" class="form-control" name="nombre" id="nombre" readonly
                                                value="{{ isset($auditoriaTendido) ? $auditoriaTendido->nombre : '' }}">
                                            &nbsp;&nbsp;
                                            <input type="text" class="form-control" name="nombre2" id="nombre2" readonly
                                                value="{{ isset($auditoriaTendido) ? $auditoriaTendido->nombre2 : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha" class="col-sm-6 col-form-label">Fecha</label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            {{ now()->format('d ') . $mesesEnEspanol[now()->format('n') - 1] . now()->format(' Y') }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="mesa" class="col-sm-6 col-form-label">MESA</label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <input type="text" class="form-control" name="mesa" id="mesa" readonly
                                                value="{{ isset($auditoriaTendido) ? $auditoriaTendido->mesa : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="auditor" class="col-sm-6 col-form-label">AUDITOR</label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <input type="text" class="form-control me-2" name="auditor" id="auditor"
                                                value="{{ $auditorDato }}" readonly required />
                                            <input type="hidden" name="auditor" value="{{ $auditorDato }}">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="codigo_material" class="col-sm-6 col-form-label">1. Codigo de
                                            material</label>
                                        <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                            <div class="form-check form-check-inline">
                                                @if(isset($auditoriaTendido) && $auditoriaTendido->codigo_material_estatus == 1)
                                                    <label class="label-paloma" for="codigo_material_estatus1">✔</label>
                                                @elseif(isset($auditoriaTendido) && $auditoriaTendido->codigo_material_estatus == 0)
                                                    <label class="label-tache" for="codigo_material_estatus2">✖</label>
                                                @endif
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="text" class="form-control me-2"
                                                    name="codigo_material" id="codigo_material" readonly
                                                    value="{{ isset($auditoriaTendido) ? $auditoriaTendido->codigo_material : '' }}"
                                                    required />
                                            </div>                                              
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="codigo_color" class="col-sm-6 col-form-label">2. Codigo de
                                            color</label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <div class="col-sm-12 d-flex align-items-center"
                                                style="margin-right: -5px;">
                                                <div class="form-check form-check-inline">
                                                    @if(isset($auditoriaTendido) && $auditoriaTendido->codigo_color_estatus == 1)
                                                        <label class="label-paloma" for="codigo_color_estatus1">✔</label>
                                                    @elseif(isset($auditoriaTendido) && $auditoriaTendido->codigo_color_estatus == 0)
                                                        <label class="label-tache" for="codigo_color_estatus2">✖</label>
                                                    @endif
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="text" class="form-control me-2" name="codigo_color" id="codigo_color"
                                                           value="{{ $encabezadoAuditoriaCorte->color }}" readonly required />
                                                    <input type="hidden" name="codigo_color" value="{{ $encabezadoAuditoriaCorte->color }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="informacion_trazo" class="col-sm-6 col-form-label">3. Informacion
                                            de trazo</label>
                                        <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                            <div class="form-check form-check-inline">
                                                @if(isset($auditoriaTendido) && $auditoriaTendido->informacion_trazo_estatus == 1)
                                                    <label class="label-paloma" for="informacion_trazo_estatus1">✔</label>
                                                @elseif(isset($auditoriaTendido) && $auditoriaTendido->informacion_trazo_estatus == 0)
                                                    <label class="label-tache" for="informacion_trazo_estatus2">✖</label>
                                                @endif
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="text" class="form-control" name="informacion_trazo" id="informacion_trazo" readonly
                                                value="{{ isset($auditoriaTendido) ? $auditoriaTendido->informacion_trazo : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cantidad_lienzo" class="col-sm-6 col-form-label">4. Cantidad de
                                            lienzos</label>
                                        <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                            <div class="form-check form-check-inline">
                                                @if(isset($auditoriaTendido) && $auditoriaTendido->cantidad_lienzo_estatus == 1)
                                                    <label class="label-paloma" for="cantidad_lienzo_estatus1">✔</label>
                                                @elseif(isset($auditoriaTendido) && $auditoriaTendido->cantidad_lienzo_estatus == 0)
                                                    <label class="label-tache" for="cantidad_lienzo_estatus2">✖</label>
                                                @endif
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="text" class="form-control me-2" name="cantidad_lienzo" id="cantidad_lienzo"
                                                       value="{{ $encabezadoAuditoriaCorte->lienzo }}" readonly required />
                                                <input type="hidden" name="cantidad_lienzo" value="{{ $encabezadoAuditoriaCorte->lienzo }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="longitud_tendido" class="col-sm-6 col-form-label">5. Longitud de
                                            tendido</label>
                                        <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                            <div class="form-check form-check-inline">
                                                @if(isset($auditoriaTendido) && $auditoriaTendido->longitud_tendido_estatus == 1)
                                                    <label class="label-paloma" for="longitud_tendido_estatus1">✔</label>
                                                @elseif(isset($auditoriaTendido) && $auditoriaTendido->longitud_tendido_estatus == 0)
                                                    <label class="label-tache" for="longitud_tendido_estatus2">✖</label>
                                                @endif
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="text" class="form-control me-2" name="longitud_tendido" id="longitud_tendido"
                                                       value="{{ $auditoriaMarcada->largo_trazo }}" readonly required />
                                                <input type="hidden" name="longitud_tendido" value="{{ $auditoriaMarcada->largo_trazo }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="ancho_tendido" class="col-sm-6 col-form-label">6. Ancho de
                                            tendido</label>
                                        <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                            <div class="form-check form-check-inline">
                                                @if(isset($auditoriaTendido) && $auditoriaTendido->ancho_tendido_estatus == 1)
                                                    <label class="label-paloma" for="ancho_tendido_estatus1">✔</label>
                                                @elseif(isset($auditoriaTendido) && $auditoriaTendido->ancho_tendido_estatus == 0)
                                                    <label class="label-tache" for="ancho_tendido_estatus1">✖</label>
                                                @endif
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="text" class="form-control me-2" name="ancho_tendido" id="ancho_tendido"
                                                       value="{{ $auditoriaMarcada->ancho_trazo }}" readonly />
                                                <input type="hidden" name="ancho_tendido" value="{{ $auditoriaMarcada->ancho_trazo }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="material_relajado" class="col-sm-6 col-form-label">7. Material relajado</label>
                                        <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                            <div class="form-check form-check-inline">
                                                @if(isset($auditoriaTendido) && $auditoriaTendido->material_relajado_estatus == 1)
                                                    <label class="label-paloma" for="material_relajado_estatus1">✔</label>
                                                @elseif(isset($auditoriaTendido) && $auditoriaTendido->material_relajado_estatus == 0)
                                                    <label class="label-tache" for="material_relajado_estatus1">✖</label>
                                                @endif
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="text" class="form-control" name="informacion_trazo" id="informacion_trazo" readonly
                                                    value="{{ isset($auditoriaTendido) ? $auditoriaTendido->material_relajado : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="empalme" class="col-sm-6 col-form-label">8. Empalmes</label>
                                        <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                            <div class="form-check form-check-inline">
                                                @if(isset($auditoriaTendido) && $auditoriaTendido->empalme_estatus == 1)
                                                    <label class="label-paloma" for="empalme_estatus1">✔</label>
                                                @elseif(isset($auditoriaTendido) && $auditoriaTendido->empalme_estatus == 0)
                                                    <label class="label-tache" for="empalme_estatus2">✖</label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cara_material" class="col-sm-6 col-form-label">9. Cara de
                                            material</label>
                                        <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                            <div class="form-check form-check-inline">
                                                @if(isset($auditoriaTendido) && $auditoriaTendido->cara_material_estatus == 1)
                                                    <label class="label-paloma" for="cara_material_estatus1">✔</label>
                                                @elseif(isset($auditoriaTendido) && $auditoriaTendido->cara_material_estatus == 0)
                                                    <label class="label-tache" for="cara_material_estatus2">✖</label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tono" class="col-sm-6 col-form-label">10. Tonos</label>
                                        <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                            <div class="form-check form-check-inline">
                                                @if(isset($auditoriaTendido) && $auditoriaTendido->tono_estatus == 1)
                                                    <label class="label-paloma" for="tono_estatus1">✔</label>
                                                @elseif(isset($auditoriaTendido) && $auditoriaTendido->tono_estatus == 0)
                                                    <label class="label-tache" for="tono_estatus2">✖</label>
                                                @endif
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="text" class="form-control me-2"
                                                    name="tono" id="tono" readonly
                                                    value="{{ isset($auditoriaTendido) ? $auditoriaTendido->tono : '' }}"
                                                    required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="alineacion_tendido" class="col-sm-6 col-form-label">11. Alineacion de tendido</label>
                                        <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                            <div class="form-check form-check-inline">
                                                <input type="text" class="form-control" name="informacion_trazo" id="informacion_trazo" readonly
                                                    value="{{ isset($auditoriaTendido) ? $auditoriaTendido->alineacion_tendido : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="arruga_tendido" class="col-sm-6 col-form-label">12. Arrugas de
                                            tendido</label>
                                        <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                            <div class="form-check form-check-inline">
                                                <input type="text" class="form-control" name="informacion_trazo" id="informacion_trazo" readonly
                                                    value="{{ isset($auditoriaTendido) ? $auditoriaTendido->arruga_tendido : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="defecto_material" class="col-sm-6 col-form-label">13. defecto de
                                            material</label>
                                        <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                            <div class="form-check form-check-inline">
                                                <input type="text" class="form-control" name="informacion_trazo" id="informacion_trazo" readonly
                                                    value="{{ isset($auditoriaTendido) ? $auditoriaTendido->defecto_material : '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="accion_correctiva" class="col-sm-6 col-form-label">Accion
                                            correctiva </label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <input type="text" class="form-control me-2" name="accion_correctiva"
                                                id="accion_correctiva" readonly
                                                value="{{ isset($auditoriaTendido) ? $auditoriaTendido->accion_correctiva : '' }}" />
                                        </div>
                                    </div>
                                </div>
                                @endif
                                {{-- Fin cuerpo acordeon --}}
                            </div>
                        </div>
                    </div>
                    <!--Fin acordeon 2 -->
                    <!--Inicio acordeon 3 -->
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button id="btnThree" class="btn btn-info btn-block collapsed" data-toggle="collapse"
                                    data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    - - LECTRA - -
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                            data-parent="#accordion">
                            <div class="card-body">
                                {{-- Inicio cuerpo acordeon --}}
                                @if ($encabezadoAuditoriaCorte->estatus == 'estatusLectra')
                                <form method="POST"
                                    action="{{ route('auditoriaCorte.formLectra', ['id' => $datoAX->id]) }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $datoAX->id }}">
                                    <input type="hidden" name="idLectra" value="{{ $Lectra->id }}">
                                    <input type="hidden" name="orden" value="{{ $datoAX->orden }}">
                                    {{-- Campo oculto para el boton Finalizar --}}
                                    <input type="hidden" name="accion" value="">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nombre" class="col-sm-6 col-form-label">NOMBRE TECNICO</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <select name="nombre" id="nombre" class="form-control"
                                                    title="Por favor, selecciona una opción">
                                                    <option value="">Selecciona una opción</option>
                                                    @foreach ($CategoriaTecnico as $nombre)
                                                        <option value="{{ $nombre->nombre }}"
                                                            {{ isset($Lectra) && trim($Lectra->nombre) === trim($nombre->nombre) ? 'selected' : '' }}>
                                                            {{ $nombre->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="fecha" class="col-sm-6 col-form-label">Fecha</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                {{ now()->format('d ') . $mesesEnEspanol[now()->format('n') - 1] . now()->format(' Y') }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="mesa" class="col-sm-6 col-form-label">Maquina Lectra: </label>
                                            <div class="col-sm-12 d-flex align-items-center"> 
                                                <select name="mesa" id="mesa" class="form-control" title="Por favor, selecciona una opción"> 
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="IH8" {{ isset($Lectra) && $Lectra->mesa == 'IH8' ? 'selected' : '' }}>IH8</option>
                                                    <option value="IX6" {{ isset($Lectra) && $Lectra->mesa == 'IX6' ? 'selected' : '' }}>IX6</option>
                                                </select> 
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="auditor" class="col-sm-6 col-form-label">AUDITOR</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="text" class="form-control me-2" name="auditor" id="auditor"
                                                    value="{{ $auditorDato }}" readonly required />
                                                <input type="hidden" name="auditor" value="{{ $auditorDato }}">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        @php
                                            $options = ['-1/16', '-1/8', '-1/4', '-1/2', '0', '+1/2', '+1/4', '+1/8', '+1/16'];
                                            $paneles = ['DELANTERO', 'TRACERO', 'PARCHE', 'ADICIONAL'];
                                        @endphp
                                        <div class="col-md-6 mb-3">
                                            <label class="col-sm-6 col-form-label">1. Simetria de piezas</label>
                                            <div class="form-check form-check-inline">
                                                <label for="simetria_pieza1" class="col-sm-6 col-form-label">Panel 1</label>
                                                <input type="text" class="form-control me-2"
                                                    name="simetria_pieza1" id="simetria_pieza1" placeholder="panel 1"
                                                    value="{{ isset($Lectra) ? $Lectra->simetria_pieza1 : '' }}"
                                                    required />
                                            </div>
                                            <div class="form-check form-check-inline">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <select name="panel1_x{{ $i }}" id="panel1_x{{ $i }}" class="form-control" title="Por favor, selecciona una opción">
                                                        <option value=""> X{{$i}}° </option>
                                                        @foreach($options as $option)
                                                            <option value="{{ $option }}" {{ isset($Lectra) && $Lectra->{'panel1_x'.$i} == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                        @endforeach
                                                    </select> &nbsp;&nbsp;
                                                @endfor
                                            </div>
                                            <div class="form-check form-check-inline">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <select name="panel1_y{{ $i }}" id="panel1_y{{ $i }}" class="form-control" title="Por favor, selecciona una opción">
                                                        <option value=""> Y{{$i}}° </option>
                                                        @foreach($options as $option)
                                                            <option value="{{ $option }}" {{ isset($Lectra) && $Lectra->{'panel1_y'.$i} == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                        @endforeach
                                                    </select> &nbsp;&nbsp;
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="col-sm-6 col-form-label">&nbsp;</label>
                                            <div class="form-check form-check-inline">
                                                <label for="simetria_pieza1" class="col-sm-6 col-form-label">Panel 2</label>
                                                <input type="text" class="form-control me-2"
                                                    name="simetria_pieza2" id="simetria_pieza2" placeholder="panel 1"
                                                    value="{{ isset($Lectra) ? $Lectra->simetria_pieza2 : '' }}" />
                                            </div>
                                            <div class="form-check form-check-inline">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <select name="panel2_x{{ $i }}" id="panel2_x{{ $i }}" class="form-control" title="Por favor, selecciona una opción">
                                                        <option value=""> X{{$i}}° </option>
                                                        @foreach($options as $option)
                                                            <option value="{{ $option }}" {{ isset($Lectra) && $Lectra->{'panel2_x'.$i} == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                        @endforeach
                                                    </select> &nbsp;&nbsp;
                                                @endfor
                                            </div>
                                            <div class="form-check form-check-inline">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <select name="panel2_y{{ $i }}" id="panel2_y{{ $i }}" class="form-control" title="Por favor, selecciona una opción">
                                                        <option value=""> Y{{$i}}° </option>
                                                        @foreach($options as $option)
                                                            <option value="{{ $option }}" {{ isset($Lectra) && $Lectra->{'panel2_y'.$i} == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                        @endforeach
                                                    </select> &nbsp;&nbsp;
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check form-check-inline">
                                                <label for="simetria_pieza3" class="col-sm-6 col-form-label">Panel 3</label>
                                                <input type="text" class="form-control me-2"
                                                    name="simetria_pieza3" id="simetria_pieza3" placeholder="panel 3"
                                                    value="{{ isset($Lectra) ? $Lectra->simetria_pieza4 : '' }}" />
                                            </div>
                                            <div class="form-check form-check-inline">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <select name="panel3_x{{ $i }}" id="panel3_x{{ $i }}" class="form-control" title="Por favor, selecciona una opción">
                                                        <option value=""> X{{$i}}° </option>
                                                        @foreach($options as $option)
                                                            <option value="{{ $option }}" {{ isset($Lectra) && $Lectra->{'panel3_x'.$i} == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                        @endforeach
                                                    </select> &nbsp;&nbsp;
                                                @endfor
                                            </div>
                                            <div class="form-check form-check-inline">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <select name="panel3_y{{ $i }}" id="panel3_y{{ $i }}" class="form-control" title="Por favor, selecciona una opción">
                                                        <option value=""> Y{{$i}}° </option>
                                                        @foreach($options as $option)
                                                            <option value="{{ $option }}" {{ isset($Lectra) && $Lectra->{'panel3_y'.$i} == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                        @endforeach
                                                    </select> &nbsp;&nbsp;
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check form-check-inline">
                                                <label for="simetria_pieza4" class="col-sm-6 col-form-label">Panel 4</label>
                                                <input type="text" class="form-control me-2"
                                                    name="simetria_pieza4" id="simetria_pieza4" placeholder="panel 4"
                                                    value="{{ isset($Lectra) ? $Lectra->simetria_pieza4 : '' }}" />
                                            </div>
                                            <div class="form-check form-check-inline">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <select name="panel4_x{{ $i }}" id="panel4_x{{ $i }}" class="form-control" title="Por favor, selecciona una opción">
                                                        <option value=""> X{{$i}}° </option>
                                                        @foreach($options as $option)
                                                            <option value="{{ $option }}" {{ isset($Lectra) && $Lectra->{'panel4_x'.$i} == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                        @endforeach
                                                    </select> &nbsp;&nbsp;
                                                @endfor
                                            </div>
                                            <div class="form-check form-check-inline">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <select name="panel4_y{{ $i }}" id="panel4_y{{ $i }}" class="form-control" title="Por favor, selecciona una opción">
                                                        <option value=""> Y{{$i}}° </option>
                                                        @foreach($options as $option)
                                                            <option value="{{ $option }}" {{ isset($Lectra) && $Lectra->{'panel4_y'.$i} == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                        @endforeach
                                                    </select> &nbsp;&nbsp;
                                                @endfor
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="pieza_completa" class="col-sm-6 col-form-label">2. Piezas completas</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <div class="col-sm-12 d-flex align-items-center"
                                                    style="margin-right: -5px;">
                                                    <div class="form-check form-check-inline">
                                                        <input class="quitar-espacio" type="radio"
                                                            name="pieza_completa_estatus" id="pieza_completa_estatus1"
                                                            value="1"
                                                            {{ isset($Lectra) && $Lectra->pieza_completa_estatus == 1 ? 'checked' : '' }}
                                                            required />
                                                        <label class="label-paloma" for="pieza_completa_estatus1">✔ </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="quitar-espacio" type="radio"
                                                            name="pieza_completa_estatus" id="pieza_completa_estatus2"
                                                            value="0"
                                                            {{ isset($Lectra) && $Lectra->pieza_completa_estatus == 0 ? 'checked' : '' }}
                                                            required /> 
                                                        <label class="label-tache" for="pieza_completa_estatus2">✖ </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="number" step="0.0001" class="form-control me-2"
                                                            name="pieza_completa" id="pieza_completa" placeholder="..."
                                                            value="{{ isset($Lectra) ? $Lectra->pieza_completa : '' }}"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="pieza_contrapatron" class="col-sm-6 col-form-label">3. Piezas contra patron</label>
                                            <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="pieza_contrapatron_estatus" id="pieza_contrapatron_estatus1"
                                                        value="1"
                                                        {{ isset($Lectra) && $Lectra->pieza_contrapatron_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="pieza_contrapatron_estatus1">✔
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="pieza_contrapatron_estatus" id="pieza_contrapatron_estatus2"
                                                        value="0"
                                                        {{ isset($Lectra) && $Lectra->pieza_contrapatron_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="pieza_contrapatron_estatus2">✖ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="number" step="0.0001" class="form-control me-2"
                                                        name="pieza_contrapatron" id="pieza_contrapatron" placeholder="..."
                                                        value="{{ isset($Lectra) ? $Lectra->pieza_contrapatron : '' }}"
                                                        required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="pieza_inspeccionada" class="col-sm-6 col-form-label">Piezas inspeccionadas</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <select name="pieza_inspeccionada" id="pieza_inspeccionada" class="form-control" title="Por favor, selecciona una opción">
                                                    <option value="">Selecciona una opción</option>
                                                    <option value="2" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '2' ? 'selected' : '' }}>2 - 8 => 2</option>
                                                    <option value="3" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '3' ? 'selected' : '' }}>9 - 15 => 3 </option>
                                                    <option value="5" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '5' ? 'selected' : '' }}>16 - 25 => 5 </option>
                                                    <option value="8" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '8' ? 'selected' : '' }}>26 - 50 => 8 </option>
                                                    <option value="13" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '13' ? 'selected' : '' }}>51 - 90 => 13 </option>
                                                    <option value="20" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '20' ? 'selected' : '' }}>91 - 150 => 20 </option>
                                                    <option value="32" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '32' ? 'selected' : '' }}>151 - 280 => 32 </option>
                                                    <option value="50" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '50' ? 'selected' : '' }}>281 - 500 => 50 </option>
                                                    <option value="80" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '80' ? 'selected' : '' }}>501 - 1,200 => 80 </option>
                                                    <option value="125" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '125' ? 'selected' : '' }}>1,201 - 3,200 => 125 </option>
                                                    <option value="200" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '200' ? 'selected' : '' }}>3,201 - 10,000 => 200 </option>
                                                    <option value="315" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '315' ? 'selected' : '' }}>10,001 - 35,000 => 315 </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="cantidad_defecto" class="col-sm-6 col-form-label">Cantidad de Defectos </label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="text" class="form-control me-2" name="cantidad_defecto"
                                                    id="cantidad_defecto" placeholder="..."
                                                    value="{{ isset($Lectra) ? $Lectra->cantidad_defecto : '' }}"
                                                    required />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="defecto" class="col-sm-6 col-form-label">Defectos </label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="text" class="form-control me-2" name="defecto"
                                                    id="defecto" placeholder="..."
                                                    value="{{ isset($Lectra) ? $Lectra->defecto : '' }}"
                                                    required />
                                                {{--
                                                <select name="defecto" id="defecto" class="form-control"
                                                    title="Por favor, selecciona una opción">
                                                    <option value="">Selecciona una opción</option>
                                                    
                                                    @foreach ($CategoriaDefectoCorte as $defectoCorte)
                                                        <option value="{{ $defectoCorte->nombre }}"
                                                            {{ isset($Lectra) && trim($Lectra->defecto) == trim($defectoCorte->nombre) ? 'selected' : '' }}>
                                                            {{ $defectoCorte->nombre }}</option>
                                                    @endforeach
                                                </select>
                                                --}}
                                            </div>
                                        </div>
                                        @php
                                            $cantidadDefecto = isset($Lectra->cantidad_defecto) ? $Lectra->cantidad_defecto : 0;
                                            $piezaInspeccionada = isset($Lectra->pieza_inspeccionada) ? $Lectra->pieza_inspeccionada : 0;
                                            $calculoPorcentaje = $piezaInspeccionada != 0 ? intval(($cantidadDefecto / $piezaInspeccionada) * 100) : 0;
                                        @endphp
                                        <div class="col-md-6 mb-3">
                                            <label for="porcentaje" class="col-sm-6 col-form-label">Porcentaje</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="text" class="form-control me-2" name="porcentaje" id="porcentaje" placeholder="..."
                                                    value="{{ isset($calculoPorcentaje) ? $calculoPorcentaje : '' }}" readonly />
                                                <span>%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        @if($mostrarFinalizarLectra)
                                            <button type="submit" class="btn btn-danger" value="finalizar" name="accion" >Finalizar</button>
                                        @else
                                            <button type="submit" class="btn btn-danger" disabled>Finalizar</button>
                                        @endif
                                    </div>
                                </form>
                                @elseif($encabezadoAuditoriaCorte && ($encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaMarcada' || $encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaTendido' || $encabezadoAuditoriaCorte->estatus == 'estatusLectra' || $encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaBulto' || $encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaFinal' || $encabezadoAuditoriaCorte->estatus == 'fin'))
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="col-sm-6 col-form-label">NOMBRE TECNICO</label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <input type="text" class="form-control" name="nombre" id="nombre" readonly
                                                value="{{ isset($Lectra) ? $Lectra->nombre : '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="fecha" class="col-sm-6 col-form-label">Fecha</label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            {{ now()->format('d ') . $mesesEnEspanol[now()->format('n') - 1] . now()->format(' Y') }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="mesa" class="col-sm-6 col-form-label">Maquina Lectra: </label>
                                        <div class="col-sm-12 d-flex align-items-center"> 
                                            <select name="mesa" id="mesa" class="form-control" title="Por favor, selecciona una opción"> 
                                                <option value="">Selecciona una opción</option>
                                                <option value="IH8" {{ isset($Lectra) && $Lectra->mesa == 'IH8' ? 'selected' : '' }}>IH8</option>
                                                <option value="IX6" {{ isset($Lectra) && $Lectra->mesa == 'IX6' ? 'selected' : '' }}>IX6</option>
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="auditor" class="col-sm-6 col-form-label">AUDITOR</label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <input type="text" class="form-control me-2" name="auditor" id="auditor"
                                                value="{{ $auditorDato }}" readonly required />
                                            <input type="hidden" name="auditor" value="{{ $auditorDato }}">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    @php
                                        $options = ['-1/16', '-1/8', '-1/4', '-1/2', '0', '+1/2', '+1/4', '+1/8', '+1/16'];
                                        $paneles = ['DELANTERO', 'TRACERO', 'PARCHE', 'ADICIONAL'];
                                    @endphp
                                    <div class="col-md-6 mb-3">
                                        <label class="col-sm-6 col-form-label">1. Simetria de piezas</label>
                                        <div class="form-check form-check-inline">
                                            <label for="simetria_pieza1" class="col-sm-6 col-form-label">Panel 1</label>
                                            <input type="text" class="form-control me-2"
                                                name="simetria_pieza1" id="simetria_pieza1" placeholder="panel 1" readonly
                                                value="{{ isset($Lectra) ? $Lectra->simetria_pieza1 : '' }}"
                                                 />
                                        </div>
                                        <div class="form-check form-check-inline">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <input type="text" class="form-control" value=" {{ isset($Lectra) ? $Lectra->{'panel1_x'.$i} : '' }}" readonly> &nbsp;&nbsp;
                                            @endfor
                                        </div>
                                        <div class="form-check form-check-inline">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <select name="panel1_y{{ $i }}" id="panel1_y{{ $i }}" class="form-control" title="Por favor, selecciona una opción">
                                                    <option value=""> Y{{$i}}° </option>
                                                    @foreach($options as $option)
                                                        <option value="{{ $option }}" {{ isset($Lectra) && $Lectra->{'panel1_y'.$i} == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                    @endforeach
                                                </select> &nbsp;&nbsp;
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="col-sm-6 col-form-label">&nbsp;</label>
                                        <div class="form-check form-check-inline">
                                            <label for="simetria_pieza1" class="col-sm-6 col-form-label">Panel 2</label>
                                            <input type="text" class="form-control me-2"
                                                name="simetria_pieza2" id="simetria_pieza2" placeholder="panel 1"
                                                value="{{ isset($Lectra) ? $Lectra->simetria_pieza2 : '' }}" />
                                        </div>
                                        <div class="form-check form-check-inline">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <select name="panel2_x{{ $i }}" id="panel2_x{{ $i }}" class="form-control" title="Por favor, selecciona una opción">
                                                    <option value=""> X{{$i}}° </option>
                                                    @foreach($options as $option)
                                                        <option value="{{ $option }}" {{ isset($Lectra) && $Lectra->{'panel2_x'.$i} == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                    @endforeach
                                                </select> &nbsp;&nbsp;
                                            @endfor
                                        </div>
                                        <div class="form-check form-check-inline">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <select name="panel2_y{{ $i }}" id="panel2_y{{ $i }}" class="form-control" title="Por favor, selecciona una opción">
                                                    <option value=""> Y{{$i}}° </option>
                                                    @foreach($options as $option)
                                                        <option value="{{ $option }}" {{ isset($Lectra) && $Lectra->{'panel2_y'.$i} == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                    @endforeach
                                                </select> &nbsp;&nbsp;
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-check-inline">
                                            <label for="simetria_pieza3" class="col-sm-6 col-form-label">Panel 3</label>
                                            <input type="text" class="form-control me-2"
                                                name="simetria_pieza3" id="simetria_pieza3" placeholder="panel 3"
                                                value="{{ isset($Lectra) ? $Lectra->simetria_pieza4 : '' }}" />
                                        </div>
                                        <div class="form-check form-check-inline">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <select name="panel3_x{{ $i }}" id="panel3_x{{ $i }}" class="form-control" title="Por favor, selecciona una opción">
                                                    <option value=""> X{{$i}}° </option>
                                                    @foreach($options as $option)
                                                        <option value="{{ $option }}" {{ isset($Lectra) && $Lectra->{'panel3_x'.$i} == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                    @endforeach
                                                </select> &nbsp;&nbsp;
                                            @endfor
                                        </div>
                                        <div class="form-check form-check-inline">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <select name="panel3_y{{ $i }}" id="panel3_y{{ $i }}" class="form-control" title="Por favor, selecciona una opción">
                                                    <option value=""> Y{{$i}}° </option>
                                                    @foreach($options as $option)
                                                        <option value="{{ $option }}" {{ isset($Lectra) && $Lectra->{'panel3_y'.$i} == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                    @endforeach
                                                </select> &nbsp;&nbsp;
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-check form-check-inline">
                                            <label for="simetria_pieza4" class="col-sm-6 col-form-label">Panel 4</label>
                                            <input type="text" class="form-control me-2"
                                                name="simetria_pieza4" id="simetria_pieza4" placeholder="panel 4"
                                                value="{{ isset($Lectra) ? $Lectra->simetria_pieza4 : '' }}" />
                                        </div>
                                        <div class="form-check form-check-inline">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <select name="panel4_x{{ $i }}" id="panel4_x{{ $i }}" class="form-control" title="Por favor, selecciona una opción">
                                                    <option value=""> X{{$i}}° </option>
                                                    @foreach($options as $option)
                                                        <option value="{{ $option }}" {{ isset($Lectra) && $Lectra->{'panel4_x'.$i} == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                    @endforeach
                                                </select> &nbsp;&nbsp;
                                            @endfor
                                        </div>
                                        <div class="form-check form-check-inline">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <select name="panel4_y{{ $i }}" id="panel4_y{{ $i }}" class="form-control" title="Por favor, selecciona una opción">
                                                    <option value=""> Y{{$i}}° </option>
                                                    @foreach($options as $option)
                                                        <option value="{{ $option }}" {{ isset($Lectra) && $Lectra->{'panel4_y'.$i} == $option ? 'selected' : '' }}>{{ $option }}</option>
                                                    @endforeach
                                                </select> &nbsp;&nbsp;
                                            @endfor
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="pieza_completa" class="col-sm-6 col-form-label">2. Piezas completas</label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <div class="col-sm-12 d-flex align-items-center"
                                                style="margin-right: -5px;">
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="pieza_completa_estatus" id="pieza_completa_estatus1"
                                                        value="1"
                                                        {{ isset($Lectra) && $Lectra->pieza_completa_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="pieza_completa_estatus1">✔ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="pieza_completa_estatus" id="pieza_completa_estatus2"
                                                        value="0"
                                                        {{ isset($Lectra) && $Lectra->pieza_completa_estatus == 0 ? 'checked' : '' }}
                                                        required /> 
                                                    <label class="label-tache" for="pieza_completa_estatus2">✖ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="number" step="0.0001" class="form-control me-2"
                                                        name="pieza_completa" id="pieza_completa" placeholder="..."
                                                        value="{{ isset($Lectra) ? $Lectra->pieza_completa : '' }}"
                                                        required />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="pieza_contrapatron" class="col-sm-6 col-form-label">3. Piezas contra patron</label>
                                        <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                            <div class="form-check form-check-inline">
                                                <input class="quitar-espacio" type="radio"
                                                    name="pieza_contrapatron_estatus" id="pieza_contrapatron_estatus1"
                                                    value="1"
                                                    {{ isset($Lectra) && $Lectra->pieza_contrapatron_estatus == 1 ? 'checked' : '' }}
                                                    required />
                                                <label class="label-paloma" for="pieza_contrapatron_estatus1">✔
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="quitar-espacio" type="radio"
                                                    name="pieza_contrapatron_estatus" id="pieza_contrapatron_estatus2"
                                                    value="0"
                                                    {{ isset($Lectra) && $Lectra->pieza_contrapatron_estatus == 0 ? 'checked' : '' }}
                                                    required />
                                                <label class="label-tache" for="pieza_contrapatron_estatus2">✖ </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="number" step="0.0001" class="form-control me-2"
                                                    name="pieza_contrapatron" id="pieza_contrapatron" placeholder="..."
                                                    value="{{ isset($Lectra) ? $Lectra->pieza_contrapatron : '' }}"
                                                    required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="pieza_inspeccionada" class="col-sm-6 col-form-label">Piezas inspeccionadas</label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <select name="pieza_inspeccionada" id="pieza_inspeccionada" class="form-control" title="Por favor, selecciona una opción">
                                                <option value="">Selecciona una opción</option>
                                                <option value="2" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '2' ? 'selected' : '' }}>2 - 8 => 2</option>
                                                <option value="3" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '3' ? 'selected' : '' }}>9 - 15 => 3 </option>
                                                <option value="5" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '5' ? 'selected' : '' }}>16 - 25 => 5 </option>
                                                <option value="8" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '8' ? 'selected' : '' }}>26 - 50 => 8 </option>
                                                <option value="13" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '13' ? 'selected' : '' }}>51 - 90 => 13 </option>
                                                <option value="20" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '20' ? 'selected' : '' }}>91 - 150 => 20 </option>
                                                <option value="32" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '32' ? 'selected' : '' }}>151 - 280 => 32 </option>
                                                <option value="50" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '50' ? 'selected' : '' }}>281 - 500 => 50 </option>
                                                <option value="80" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '80' ? 'selected' : '' }}>501 - 1,200 => 80 </option>
                                                <option value="125" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '125' ? 'selected' : '' }}>1,201 - 3,200 => 125 </option>
                                                <option value="200" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '200' ? 'selected' : '' }}>3,201 - 10,000 => 200 </option>
                                                <option value="315" {{ isset($Lectra) && $Lectra->pieza_inspeccionada == '315' ? 'selected' : '' }}>10,001 - 35,000 => 315 </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cantidad_defecto" class="col-sm-6 col-form-label">Cantidad de Defectos </label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <input type="text" class="form-control me-2" name="cantidad_defecto"
                                                id="cantidad_defecto" placeholder="..."
                                                value="{{ isset($Lectra) ? $Lectra->cantidad_defecto : '' }}"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="defecto" class="col-sm-6 col-form-label">Defectos </label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <input type="text" class="form-control me-2" name="defecto"
                                                id="defecto" placeholder="..."
                                                value="{{ isset($Lectra) ? $Lectra->defecto : '' }}"
                                                required />
                                            {{--
                                            <select name="defecto" id="defecto" class="form-control"
                                                title="Por favor, selecciona una opción">
                                                <option value="">Selecciona una opción</option>
                                                
                                                @foreach ($CategoriaDefectoCorte as $defectoCorte)
                                                    <option value="{{ $defectoCorte->nombre }}"
                                                        {{ isset($Lectra) && trim($Lectra->defecto) == trim($defectoCorte->nombre) ? 'selected' : '' }}>
                                                        {{ $defectoCorte->nombre }}</option>
                                                @endforeach
                                            </select>
                                            --}}
                                        </div>
                                    </div>
                                    @php
                                        $cantidadDefecto = isset($Lectra->cantidad_defecto) ? $Lectra->cantidad_defecto : 0;
                                        $piezaInspeccionada = isset($Lectra->pieza_inspeccionada) ? $Lectra->pieza_inspeccionada : 0;
                                        $calculoPorcentaje = $piezaInspeccionada != 0 ? intval(($cantidadDefecto / $piezaInspeccionada) * 100) : 0;
                                    @endphp
                                    <div class="col-md-6 mb-3">
                                        <label for="porcentaje" class="col-sm-6 col-form-label">Porcentaje</label>
                                        <div class="col-sm-12 d-flex align-items-center">
                                            <input type="text" class="form-control me-2" name="porcentaje" id="porcentaje" placeholder="..."
                                                value="{{ isset($calculoPorcentaje) ? $calculoPorcentaje : '' }}" readonly />
                                            <span>%</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                {{-- Fin cuerpo acordeon --}}
                            </div>
                        </div>
                    </div>
                    <!--Fin acordeon 3 -->
                    <!--Inicio acordeon 4 -->
                    <div class="card">
                        <div class="card-header" id="headingFour">
                            <h5 class="mb-0">
                                <button id="btnFour" class="btn btn-info btn-block collapsed" data-toggle="collapse"
                                    data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    - - AUDITORIA EN BULTOS - -
                                </button>
                            </h5>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                            <div class="card-body">
                                {{-- Inicio cuerpo acordeon --}}
                                @if ($encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaBulto')
                                <form method="POST"
                                    action="{{ route('auditoriaCorte.formAuditoriaBulto', ['id' => $datoAX->id]) }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $datoAX->id }}">
                                    <input type="hidden" name="idBulto" value="{{ $auditoriaBulto->id }}">
                                    <input type="hidden" name="orden" value="{{ $datoAX->orden }}">
                                    {{-- Campo oculto para el boton Finalizar --}}
                                    <input type="hidden" name="accion" value="">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="nombre" class="col-sm-6 col-form-label">NOMBRE TECNICO</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <select name="nombre" id="nombre" class="form-control"
                                                    title="Por favor, selecciona una opción">
                                                    <option value="">Selecciona una opción</option>
                                                    @foreach ($CategoriaTecnico as $nombre)
                                                        <option value="{{ $nombre->nombre }}"
                                                            {{ isset($auditoriaBulto) && trim($auditoriaBulto->nombre) === trim($nombre->nombre) ? 'selected' : '' }}>
                                                            {{ $nombre->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="fecha" class="col-sm-6 col-form-label">Fecha</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                {{ now()->format('d ') . $mesesEnEspanol[now()->format('n') - 1] . now()->format(' Y') }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            @php
                                                $nombreMesa = "SELLADO";
                                            @endphp
                                            <label for="mesa" class="col-sm-6 col-form-label">MESA</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="text" class="form-control me-2" name="mesa" id="mesa" placeholder="..."
                                                    value="{{ isset($nombreMesa) ? $nombreMesa : '' }}" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="auditor" class="col-sm-6 col-form-label">AUDITOR</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <div class="col-sm-12 d-flex align-items-center">
                                                    <input type="text" class="form-control me-2" name="auditor" id="auditor"
                                                        value="{{ $auditorDato }}" readonly required />
                                                    <input type="hidden" name="auditor" value="{{ $auditorDato }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            @php
                                                // Primero, verificamos si la variable existe
                                                $calculoPorcentajeBulto = isset($auditoriaBulto->pieza_paquete) ?

                                                // Si existe, verificamos si es igual a 0
                                                ($auditoriaBulto->pieza_paquete === 0 ? 0 : intval(($encabezadoAuditoriaCorte->pieza / $auditoriaBulto->pieza_paquete)))

                                                // Si no existe, asignamos 0
                                                : 0;
                                                //dd($calculoPorcentajeBulto, $encabezadoAuditoriaCorte->pieza, $auditoriaBulto->pieza_paquete);
                                            @endphp
                                            <label for="cantidad_bulto" class="col-sm-6 col-form-label">1. Cantidad de Bultos</label>
                                            <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                                {{--
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="cantidad_bulto_estatus" id="cantidad_bulto_estatus1"
                                                        value="1"
                                                        {{ isset($auditoriaBulto) && $auditoriaBulto->cantidad_bulto_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="cantidad_bulto_estatus1">✔ </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="cantidad_bulto_estatus" id="cantidad_bulto_estatus2"
                                                        value="0"
                                                        {{ isset($auditoriaBulto) && $auditoriaBulto->cantidad_bulto_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="cantidad_bulto_estatus2">✖ </label>
                                                </div>
                                                --}}
                                                <div class="form-check form-check-inline">
                                                    <input type="text" class="form-control me-2" name="cantidad_bulto" id="cantidad_bulto" placeholder="..."
                                                        value="{{ isset($calculoPorcentajeBulto) ? $calculoPorcentajeBulto : '' }}" readonly />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="pieza_paquete" class="col-sm-6 col-form-label">2. Piezas por paquete</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <div class="col-sm-12 d-flex align-items-center"
                                                    style="margin-right: -5px;">
                                                    {{--
                                                    <div class="form-check form-check-inline">
                                                        <input class="quitar-espacio" type="radio"
                                                            name="pieza_paquete_estatus" id="pieza_paquete_estatus1"
                                                            value="1"
                                                            {{ isset($auditoriaBulto) && $auditoriaBulto->pieza_paquete_estatus == 1 ? 'checked' : '' }}
                                                            required />
                                                        <label class="label-paloma" for="pieza_paquete_estatus1">✔ </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="quitar-espacio" type="radio"
                                                            name="pieza_paquete_estatus" id="pieza_paquete_estatus2"
                                                            value="0"
                                                            {{ isset($auditoriaBulto) && $auditoriaBulto->pieza_paquete_estatus == 0 ? 'checked' : '' }}
                                                            required />
                                                        <label class="label-tache" for="pieza_paquete_estatus2">✖ </label>
                                                    </div>
                                                    --}}
                                                    <div class="form-check form-check-inline">
                                                        <input type="number" step="0.0001" class="form-control me-2"
                                                            name="pieza_paquete" id="pieza_paquete" placeholder="..."
                                                            value="{{ isset($auditoriaBulto) ? $auditoriaBulto->pieza_paquete : '' }}"
                                                            required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="ingreso_ticket" class="col-sm-6 col-form-label">3. Ingreso de Tickets</label>
                                            <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="ingreso_ticket_estatus" id="ingreso_ticket_estatus1"
                                                        value="1"
                                                        {{ isset($auditoriaBulto) && $auditoriaBulto->ingreso_ticket_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="ingreso_ticket_estatus1">✔
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="ingreso_ticket_estatus" id="ingreso_ticket_estatus2"
                                                        value="0"
                                                        {{ isset($auditoriaBulto) && $auditoriaBulto->ingreso_ticket_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="ingreso_ticket_estatus2">✖ </label>
                                                </div>
                                                {{--
                                                <div class="form-check form-check-inline">
                                                    <input type="number" step="0.0001" class="form-control me-2"
                                                        name="ingreso_ticket" id="ingreso_ticket" placeholder="..."
                                                        value="{{ isset($auditoriaBulto) ? $auditoriaBulto->ingreso_ticket : '' }}"
                                                        required />
                                                </div>
                                                --}}
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="sellado_paquete" class="col-sm-6 col-form-label">4. Sellado de Paquetes</label>
                                            <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="sellado_paquete_estatus" id="sellado_paquete_estatus1"
                                                        value="1"
                                                        {{ isset($auditoriaBulto) && $auditoriaBulto->sellado_paquete_estatus == 1 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-paloma" for="sellado_paquete_estatus1">✔
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="quitar-espacio" type="radio"
                                                        name="sellado_paquete_estatus" id="sellado_paquete_estatus2"
                                                        value="0"
                                                        {{ isset($auditoriaBulto) && $auditoriaBulto->sellado_paquete_estatus == 0 ? 'checked' : '' }}
                                                        required />
                                                    <label class="label-tache" for="sellado_paquete_estatus2">✖ </label>
                                                </div>
                                                {{--
                                                <div class="form-check form-check-inline">
                                                    <input type="number" step="0.0001" class="form-control me-2"
                                                        name="sellado_paquete" id="sellado_paquete" placeholder="..."
                                                        value="{{ isset($auditoriaBulto) ? $auditoriaBulto->sellado_paquete : '' }}"
                                                        required />
                                                </div>
                                                --}}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="defecto" class="col-sm-6 col-form-label">Defectos </label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="text" class="form-control me-2" name="defecto"
                                                    id="defecto" placeholder="..."
                                                    value="{{ isset($auditoriaBulto) ? $auditoriaBulto->defecto : '' }}"
                                                    required />
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="porcentaje" class="col-sm-6 col-form-label">Porcentaje</label>
                                            <div class="col-sm-12 d-flex align-items-center">
                                                <input type="text" class="form-control me-2" name="porcentaje"
                                                    id="porcentaje" placeholder="..."
                                                    value="{{ isset($auditoriaBulto) ? $auditoriaBulto->porcentaje : '' }}"
                                                    required />
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        @if($mostrarFinalizarBulto)
                                            <button type="submit" class="btn btn-danger" value="finalizar" name="accion" >Finalizar</button>
                                        @else
                                            <button type="submit" class="btn btn-danger" disabled>Finalizar</button>
                                        @endif
                                    </div>
                                </form>
                                @endif
                                {{-- Fin cuerpo acordeon --}}
                            </div>
                        </div>
                    </div>
                    <!--Fin acordeon 4 -->
                    <!--Inicio acordeon 5 -->
                    <div class="card">
                        <div class="card-header" id="headingFive">
                            <h5 class="mb-0">
                                <button id="btnFive" class="btn btn-info btn-block collapsed" data-toggle="collapse"
                                    data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    - - AUDITORIA FINAL - -
                                </button>
                            </h5>
                        </div>
                        <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                            <div class="card-body">
                                {{-- Inicio cuerpo acordeon --}}
                                @if ($encabezadoAuditoriaCorte->estatus == 'estatusAuditoriaFinal')
                                    
                                    @if (auth()->check() && auth()->user()->no_empleado == '2222')
                                    <form method="POST"
                                        action="{{ route('auditoriaCorte.formAuditoriaFinal', ['id' => $datoAX->id]) }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $datoAX->id }}">
                                        <input type="hidden" name="idAuditoriaFinal" value="{{ $auditoriaFinal->id }}">
                                        <input type="hidden" name="orden" value="{{ $datoAX->orden }}">
                                        <input type="hidden" name="enterado" value="enterado">

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="supervisor_corte" class="col-sm-6 col-form-label">Supervisor de Corte: {{$auditorDato}} </label>
                                                <div class="col-sm-12 d-flex align-items-center">
                                                    @if($auditoriaFinal->supervisor_corte == '1')
                                                        <button type="submit" class="btn btn-success" disabled>Listo</button>
                                                    @else
                                                        <button type="submit" class="btn btn-success">Confirma de Enterado</button>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </form>
                                    @else
                                    <form method="POST"
                                        action="{{ route('auditoriaCorte.formAuditoriaFinal', ['id' => $datoAX->id]) }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $datoAX->id }}">
                                        <input type="hidden" name="idAuditoriaFinal" value="{{ $auditoriaFinal->id }}">
                                        <input type="hidden" name="orden" value="{{ $datoAX->orden }}">
                                        {{-- Campo oculto para el boton Finalizar --}}
                                        <input type="hidden" name="accion" value="">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="supervisor_corte" class="col-sm-6 col-form-label">Supervisor de Corte</label>
                                                @php
                                                    $supervisorCorteFinal = "DAVID"
                                                @endphp
                                                <div class="col-sm-12 d-flex align-items-center">
                                                    <input type="text" class="form-control me-2" name="supervisor_corte" id="supervisor_corte"
                                                        value="{{ $supervisorCorteFinal }}" readonly />
                                                    <input type="hidden" name="supervisor_corte" value="{{ $supervisorCorteFinal }}">
                                                </div>
                                                <div class="col-sm-12 d-flex align-items-center">
                                                    @if($auditoriaFinal->supervisor_corte == '1')
                                                        <h3 style="background-color: green; padding: 5px; color: white;">Enterado</h3>
                                                    @else
                                                        <h3 style="background-color: red; padding: 5px;  color: white;">No enterado</h3>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="aceptado_condicion" class="col-sm-6 col-form-label">Aceptado con condiciones :</label>
                                                <div class="col-sm-12">
                                                    <textarea class="form-control" name="aceptado_condicion" id="aceptado_condicion" rows="3"
                                                        placeholder="comentarios" required>{{ isset($auditoriaFinal) ? $auditoriaFinal->aceptado_condicion : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="aceptado_rechazado" class="col-sm-6 col-form-label">Aceptado - Rechazado</label>
                                                <div class="col-sm-12 d-flex align-items-center" style="margin-right: -5px;">
                                                    <div class="form-check form-check-inline">
                                                        <input class="quitar-espacio" type="radio"
                                                            name="aceptado_rechazado" id="estatus1"
                                                            value="1"
                                                            {{ isset($auditoriaFinal) && $auditoriaFinal->aceptado_rechazado == 1 ? 'checked' : '' }}
                                                            required />
                                                        <label class="label-paloma" for="estatus1">✔
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="quitar-espacio" type="radio"
                                                            name="aceptado_rechazado" id="estatus2"
                                                            value="0"
                                                            {{ isset($auditoriaFinal) && $auditoriaFinal->aceptado_rechazado == 0 ? 'checked' : '' }}
                                                            required />
                                                        <label class="label-tache" for="estatus2">✖ </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-success">Guardar</button>
                                            @if($mostrarFinalizarFinal)
                                                <button type="submit" class="btn btn-danger" value="finalizar" name="accion" >Finalizar</button>
                                            @else
                                                <button type="submit" class="btn btn-danger" disabled>Finalizar</button>
                                            @endif
                                        </div>
                                    </form>
                                    @endif
                                @endif
                                {{-- Fin cuerpo acordeon --}}
                            </div>
                        </div>
                    </div>
                    <!--Fin acordeon 5 -->
                </div>
                <!--Fin div de acordeon -->
            </div>
        </div>
        <style>
            /* Estilos personalizados para los elementos de tipo "radio" */
            input[type="radio"] {
                width: 20px;
                /* Ancho personalizado */
                height: 20px;
                /* Altura personalizada */
                /* Otros estilos personalizados según tus necesidades */
            }

            .label-paloma {
                font-size: 20px;
                /* Tamaño de fuente personalizado */
                color: #33a533;
                /* Color de texto personalizado */
                font-weight: bold;
                /* Texto en negritas (bold) */
                /* Otros estilos personalizados según tus necesidades */
            }

            .label-tache {
                font-size: 20px;
                /* Tamaño de fuente personalizado */
                color: #b61711;
                /* Color de texto personalizado */
                font-weight: bold;
                /* Texto en negritas (bold) */
                /* Otros estilos personalizados según tus necesidades */
            }

            .form-check-inline {
                margin-right: 25px;
            }

            .form-control.me-2 {
                margin-right: 25px;
                /* Ajusta la cantidad de margen según tus necesidades */
            }

            .quitar-espacio {
                margin-right: 10px;
            }
        </style>
        <!-- Script para abrir el acordeón correspondiente -->
        <script>
            // Obtenemos el valor del estatus desde el HTML generado por PHP en Laravel
            var estatus = @json(optional($encabezadoAuditoriaCorte)->estatus);
            const estatusTextos = {
                'estatusAuditoriaMarcada': 'Auditoria de Marcada',
                'estatusAuditoriaTendido': 'Auditoria de Tendido',
                'estatusLectra': 'Lectra',
                'estatusAuditoriaBulto': 'Auditoria en Bultos',
                'estatusAuditoriaFinal': 'Auditoria Final',
                'fin': 'Terminado'
                // Agrega otros valores para los demás estados
            };
            const estatusTexto = estatusTextos[estatus];

            // Verificamos si el valor de estatus se estableció correctamente
            if (estatus) {
                // Mostramos el valor en la página
                document.getElementById("estatusValue").innerText = "Estatus: " + estatusTexto;

                // Dependiendo del valor de estatus, abrimos el acordeón correspondiente
                switch (estatus) {
                    case "estatusAuditoriaMarcada":
                        // Abre el acordeón 1
                        document.getElementById("collapseOne").classList.add("show");
                        document.getElementById("btnOne").classList.remove("btn-info");
                        document.getElementById("btnOne").classList.add("btn-primary");
                        break;
                    case "estatusAuditoriaTendido":
                        // Abre el acordeón 2
                        document.getElementById("collapseTwo").classList.add("show");
                        document.getElementById("btnTwo").classList.remove("btn-info");
                        document.getElementById("btnTwo").classList.add("btn-primary");
                        break;
                    case "estatusLectra":
                        // Abre el acordeón 3
                        document.getElementById("collapseThree").classList.add("show");
                        document.getElementById("btnThree").classList.remove("btn-info");
                        document.getElementById("btnThree").classList.add("btn-primary");
                        break;
                    case "estatusAuditoriaBulto":
                        // Abre el acordeón 4
                        document.getElementById("collapseFour").classList.add("show");
                        document.getElementById("btnFour").classList.remove("btn-info");
                        document.getElementById("btnFour").classList.add("btn-primary");
                        break;
                    case "estatusAuditoriaFinal":
                        // Abre el acordeón 5
                        document.getElementById("collapseFive").classList.add("show");
                        document.getElementById("btnFive").classList.remove("btn-info");
                        document.getElementById("btnFive").classList.add("btn-primary");
                        break;
                    default:
                        console.log("El valor de estatus no coincide con ninguna opción válida para abrir un acordeón.");
                }
            } else {
                console.log("ERROR: No se pudo obtener el valor de estatus.");
            }
        </script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input[type="text"]');
        
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        });
    });

</script>


    @endsection
