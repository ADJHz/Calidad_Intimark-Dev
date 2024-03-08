@extends('layouts.app', ['activePage' => 'Formularios', 'titlePage' => __('Formularios')])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header card-header-primary">
          <h3 class="card-title">{{ __('Formularios.') }}</h3>
        </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="container mt-3">
                            <div class="row">
                                @if (auth()->check() && (auth()->user()->hasRole('Auditor') || auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Gerente de Calidad')) && auth()->user()->Planta == 'Planta1')
                                <!-- Opción 1 -->
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card">
                                        <img src="{{ asset('material') }}/img/Intimark.png" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">REPORTE AUDITORIA DE ETIQUETAS <br>FCC-014</h5>
                                            <a href="{{ route('formulariosCalidad.auditoriaEtiquetas') }}" class="btn btn-primary"  >INICIAR</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Opción 2 -->
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card">
                                        <img src="{{ asset('material') }}/img/Intimark.png" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">CONTROL DE CALIDAD EN CORTE <br>FCC-010</h5>
                                            <a href="{{ route('auditoriaCorte.inicioAuditoriaCorte') }}" class="btn btn-primary"  >INICIAR</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card">
                                        <img src="{{ asset('material') }}/img/Intimark.png" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">EVALUACION  DE CORTE CONTRA PATRON <br>F-4</h5>
                                            <a href="{{ route('evaluacionCorte.inicioEvaluacionCorte') }}" class="btn btn-primary"  >INICIAR</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card">
                                        <img src="{{ asset('material') }}/img/Intimark.png" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">AUDITORIA FINAL A.Q.L <br>FCC-009-B</h5>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card">
                                        <img src="{{ asset('material') }}/img/Intimark.png" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">INTIMARK CONTROL DE CALIDAD EMPAQUE<br>FCC-008</h5>

                                        </div>
                                    </div>
                                </div>
                              @endif
                              @if (auth()->check() && (auth()->user()->hasRole('Auditor') || auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Gerente de Calidad')) && auth()->user()->Planta == 'Planta2')
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card">
                                        <img src="{{ asset('material') }}/img/Intimark.png" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">SCREEN PRINT</h5>
                                            <a href="{{ route('ScreenPlanta2.ScreenPrint') }}" class="btn btn-primary"  >INICIAR</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card">
                                        <img src="{{ asset('material') }}/img/Intimark.png" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">INSPECCIÓN DESPUES DE HORNO</h5>
                                            <a href="{{ route('ScreenPlanta2.InsEstamHorno') }}" class="btn btn-primary"  >INICIAR</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card">
                                        <img src="{{ asset('material') }}/img/Intimark.png" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">CALIDAD PROCESO DE PLANCHA</h5>
                                            <a href="{{ route('ScreenPlanta2.CalidadProcesoPlancha') }}" class="btn btn-primary"  >INICIAR</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <div class="card">
                                        <img src="{{ asset('material') }}/img/Intimark.png" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">MAQUILA</h5>
                                            <a href="{{ route('ScreenPlanta2.Maquila') }}" class="btn btn-primary"  >INICIAR</a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <!-- Repite para cada opción que tengas -->

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
