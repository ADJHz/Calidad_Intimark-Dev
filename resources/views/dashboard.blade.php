@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <style>
    .card-header-custom1 {
      background-image: linear-gradient(to right, #a3e2a5d7, #4CAF50); /* Gradiente de izquierda a derecha */
      color: #fff; /* Texto en blanco para contraste */
    }
    .card-header-custom2 {
      background-image: linear-gradient(to right, #f59b95ec, #F44336); /* Gradiente de izquierda a derecha */
      color: #fff; /* Texto en blanco para contraste */
    }
    .card-header-custom3 {
      background-image: linear-gradient(to left, rgba(174, 197, 224, 0.918), #2196F3); /* Gradiente de izquierda a derecha */
      color: #fff; /* Texto en blanco para contraste */
    }

    .card-header-icono1 {
      background-image: linear-gradient(to right, rgba(174, 197, 224, 0.918), #25045a); /* Gradiente de izquierda a derecha */
      color: #fff; /* Texto en blanco para contraste */
    }
  </style>
  <div class="content">
    <div class="container-fluid">
      <div class="row"> 
        <div class="col-md-4">
          <div class="card card-stats">
            <div class="card-header-custom3">
              <p>&nbsp;AQL por dia general</p>
            </div>
            <div class="card-body">
              <h4 class="card-title">Total de Aceptados: {{$conteoPiezaAceptadoDia}}</h4>
              <h4 class="card-title">Total de Rechazos: {{$conteoPiezaConRechazoDia}}</h4>
              <h4 class="card-title">Total de registros: {{$conteoBultosDia}}</h4>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-stats">
            <div class="card-header-custom3">
              <p>&nbsp;AQL por dia Planta 1</p>
            </div>
            <div class="card-body">
              <h4 class="card-title">Total de Aceptados: {{$conteoPiezaAceptadoDiaPlanta1}}</h4>
              <h4 class="card-title">Total de Rechazos: {{$conteoPiezaConRechazoDiaPlanta1}}</h4>
              <h4 class="card-title">Total de registros: {{$conteoBultosDiaPlanta1}}</h4>
            </div>
            {{--
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">access_time</i>
              </div>
            </div>
            --}}
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-stats">
            <div class="card-header-custom3">
              <p>&nbsp;AQL por dia Planta 2</p>
            </div>
            <div class="card-body">
              <h4 class="card-title">Total de registros: {{$conteoBultosDiaPlanta2}}</h4>
              <h4 class="card-title">Total de Aceptados: {{$conteoPiezaAceptadoDiaPlanta2}}</h4>
              <h4 class="card-title">Total de Rechazos: {{$conteoPiezaConRechazoDiaPlanta2}}</h4>
            </div>
          </div>
        </div>
      </div> 
      <div class="row">
        <div class="col-md-12">
          <div class="card card-stats">
            <div class="card-header-custom3">
              <p>&nbsp;AQL Gerente de Produccion por dia Planta 1</p>
            </div>
            <div>
              <table class="table table-bordered">
                <thead class="thead-custom2 text-center">
                    <tr>
                        <th>Team Leader</th>
                        <th>Cantidad de Módulos</th>
                        <th>% Error</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($porcentajesErrorGerenteProduccion as $teamLeader => $porcentajeError)
                        <tr class="{{ ($porcentajeError > 9 && $porcentajeError <= 15) ? 'error-bajo' : ($porcentajeError > 15 ? 'error-alto' : '') }}">
                            <td>{{ $teamLeader }}</td>
                            <td>{{ $modulosPorGerenteProduccion[$teamLeader] }}</td>
                            <td>{{ number_format($porcentajeError, 2) }}%</td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
              <hr>
              <table class="table table-bordered">
                <thead class="thead-custom2 text-center">
                    <tr>
                        <th>Team Leader</th>
                        <th>Cantidad de Módulos</th>
                        <th>% Error</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($porcentajesErrorGerenteProduccionProceso as $teamLeader => $porcentajeError)
                        <tr class="{{ ($porcentajeError > 9 && $porcentajeError <= 15) ? 'error-bajo' : ($porcentajeError > 15 ? 'error-alto' : '') }}">
                            <td>{{ $teamLeader }}</td>
                            <td>{{ $modulosPorGerenteProduccionProceso[$teamLeader] }}</td>
                            <td>{{ number_format($porcentajeError, 2) }}%</td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
              <hr>
              <table class="table table-bordered">
                <thead class="thead-custom2 text-center">
                    <tr>
                        <th>Team Leader</th>
                        <th>Cantidad de Módulos</th>
                        <th>% Error AQL</th>
                        <th>% Error Proceso</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item['team_leader'] }}</td>
                            <td>{{ $item['modulos_unicos'] }}</td>
                            <td>{{ number_format($item['porcentaje_error_aql'], 2) }}%</td>
                            <td>{{ number_format($item['porcentaje_error_proceso'], 2) }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            </div>
          </div>
        </div>
      </div>
        
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">content_cut</i>
              </div>
              <p class="card-category"></p>
              <h3 class="card-title"> 
                <small>Auditoria Corte</small>
              </h3>
            </div>
            <div class="card-footer">
              {{-- <div class="stats">
                <i class="material-icons text-danger">warning</i>
                <a href="#brayam"></a>
              </div> --}}
              <div>
                <p>Metricas de datos a mostrar</p>
                <p>Cantidad Aceptada: {{$corteAprobados}}</p>
                <p>Cantidad rechazada: {{$corteRechazados}}</p>
                <p>Porcentaje de errores: {{$porcentajeTotalCorte}}%</p>

                <a href="" class="btn btn-primary">Ver Detalles</a>

              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-rose card-header-icon">
              <div class="card-icon">
                <i class="material-icons">cable</i>
              </div>
              <p class="card-category"></p>
              <h3 class="card-title">
                <small>Auditoria Proceso</small>
              </h3>
            </div>
            <div class="card-footer">
              <div>
                <p>Metricas de datos a mostrar</p>
                <p>Cantidad Aceptada: {{$procesoAprobados}}</p>
                <p>Cantidad rechazada: {{$procesoRechazados}}</p>
                <p>Porcentaje de errores: {{$totalPorcentajeProceso}}%</p>

                <a href="dashboarAProceso" class="btn btn-primary">Ver Detalles</a>

              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">perm_contact_calendar</i>
              </div>
              <p class="card-category"></p>
              <h3 class="card-title">
                <small>Auditoria Playera</small>
              </h3>
            </div>
            <div class="card-footer">
              <div>
                <p>Metricas de datos a mostrar</p>
                <p>Cantidad Aceptada: {{$playeraAprobados}}</p>
                <p>Cantidad rechazada: {{$playeraRechazados}}</p>
                <p>Porcentaje de errores: {{$totalPorcentajePlayera}}%</p>

                <a href="dashboarAProcesoPlayera" class="btn btn-primary">Ver Detalles</a>

              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-azul1 card-header-icon">
              <div class="card-icon">
                <i class="material-icons">view_in_ar</i>
              </div>
              <p class="card-category"></p>
              <h3 class="card-title">
                <small>Auditoria AQL</small>
              </h3>
            </div>
            <div class="card-footer">
              <div>
                <p>Metricas de datos a mostrar global</p>
                <p>Cantidad Aceptada: {{$aQLAprobados}}</p>
                <p>Cantidad rechazada: {{$aQLRechazados}}</p>
                <p>Porcentaje de errores: {{$totalPorcentajeAQL}}%</p> 

                <a href="dashboarAProcesoAQL" class="btn btn-primary">Ver Detalles</a>

              </div>
            </div>
          </div>
        </div>
      </div>
      {{--
      <div class="row">
        <div class="col-lg-6 col-md-12">
          <div class="card">
            <div class="card-header card-header-tabs card-header-primary">
              <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                  <span class="nav-tabs-title">Tasks:</span>
                  <ul class="nav nav-tabs" data-tabs="tabs">
                    <li class="nav-item">
                      <a class="nav-link active" href="#profile" data-toggle="tab">
                        <i class="material-icons">bug_report</i> Bugs
                        <div class="ripple-container"></div>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#messages" data-toggle="tab">
                        <i class="material-icons">code</i> Website
                        <div class="ripple-container"></div>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#settings" data-toggle="tab">
                        <i class="material-icons">cloud</i> Server
                        <div class="ripple-container"></div>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="profile">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="" checked>
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td></td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td></td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td>
                        </td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="" checked>
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td></td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane" id="messages">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="" checked>
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td>
                        </td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td></td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane" id="settings">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="">
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td></td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="" checked>
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td>
                        </td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" value="" checked>
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </td>
                        <td></td>
                        <td class="td-actions text-right">
                          <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                            <i class="material-icons">edit</i>
                          </button>
                          <button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                            <i class="material-icons">close</i>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12">
          <div class="card">
            <div class="card-header card-header-warning">
              <h4 class="card-title"></h4>
              <p class="card-category"></p>
            </div>
            <div class="card-body table-responsive">
              <table class="table table-hover">
                <thead class="text-warning">
                  <th>ID</th>
                  <th>Name</th>
                  <th>Salary</th>
                  <th>Country</th>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      --}}
    </div>
  </div>

  <style>
    .modal.fullscreen {
        width: 100vw;
        max-width: 100%;
        height: 100vh;
        max-height: 100%;
        margin: 0;
    }

    .modal-dialog.fullscreen {
        margin: 0;
        width: 100vw;
        max-width: 100%;
        height: 100vh;
        max-height: 100%;
    }

    .modal-content.fullscreen {
        height: 100%;
        border: none;
        border-radius: 0;
    }
  </style>

  <style>
    .card-header-custom1 {
      background-color: #53280f;
      color: #fff;
      padding: 1rem 1.5rem;
      border-bottom: 1px solid #ccc;
    }
  </style>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
@endpush
