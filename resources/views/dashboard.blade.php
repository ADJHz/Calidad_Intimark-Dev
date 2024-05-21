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
      background-image: linear-gradient(to left, #4CAF50, #4CAF50); /* Gradiente de izquierda a derecha */
      color: #fff; /* Texto en blanco para contraste */
    }

    .card-header-icono1 {
      background-image: linear-gradient(to right, rgba(174, 197, 224, 0.918), #25045a); /* Gradiente de izquierda a derecha */
      color: #fff; /* Texto en blanco para contraste */
    }

    .personalizado p{
      margin-left: 20px;
    }
  </style>
  <div class="content">
    <div class="container-fluid">
      <div class="row"> 
        <div class="col-md-6">
          <div class="card card-stats">
            <div class="card-header card-header-azul1 card-header-icon">
              <div class="card-icon">
                <i class="material-icons">view_in_ar</i>
              </div>
              <p class="card-category"></p>
              <h3 class="card-title" style="text-align: left; font-weight: bold;">
                Auditoria AQL por dia
              </h3>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-6 personalizado">
                <p>Pocentaje general: {{$generalAQL}}% </p>
                <p>Pocentaje Planta Ixtlahuaca: {{$generalAQLPlanta1}}% </p>
                <p>Pocentaje Planta San Bartolo: {{$generalAQLPlanta2}}% </p>
              </div>  
              <div class="col-md-6">
                <canvas id="comparativeChart" width="auto"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card card-stats">
            <div class="card-header card-header-rose card-header-icon">
              <div class="card-icon">
                <i class="material-icons">cable</i>
              </div>
              <p class="card-category"></p>
              <h3 class="card-title" style="text-align: left; font-weight: bold;">
                Auditoria PROCESO por dia
              </h3>
            </div>
            <hr>
            <div class="row">
              <div class="col-md-6 personalizado">
                <p>Pocentaje general: {{$generalProceso}}% </p>
                <p>Pocentaje Planta Ixtlahuaca: {{$generalProcesoPlanta1}}% </p>
                <p>Pocentaje Planta San Bartolo: {{$generalProcesoPlanta2}}% </p>
              </div>  
              <div class="col-md-6">
                <canvas id="comparativeChartProceso" width="150" height="150"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div> 
      <div class="row">
        <div class="col-md-12">
          <div class="card card-stats">
            <div class="card-header-custom3">
              <h3 style="font-weight: bold;"><i class="material-icons">select_all</i> Detalles generales por dia: AQL y PROCESO <a href="dashboarAProcesoAQL" class="btn btn-primary">Detalles por fechas</a></h3>
            </div>
            <div class="card-body">
              <div class="container-fluid">
                
                <!-- Sección de Clientes -->
                <div id="clientes" class="section"  >
                  <div class="col-md-6">
                      <table id="tablaClientes" class="table  table-bordered table1">
                        <h3 style="text-align: left" >Clientes &nbsp;<i class="material-icons">sensor_occupied</i></h3>
                          <thead class="thead-cliente text-center">
                              <tr>
                                  <th>Cliente</th>
                                  <th>% Error Proceso</th>
                                  <th>% Error AQL</th>
                                  <!-- Aquí puedes agregar más encabezados si es necesario -->
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($dataCliente as $clienteData)
                                  <tr class="{{ ($clienteData['porcentajeErrorProceso'] > 9 && $clienteData['porcentajeErrorProceso'] <= 15) ? 'error-bajo' : ($clienteData['porcentajeErrorProceso'] > 15 ? 'error-alto' : '') }}">
                                      <td>{{ $clienteData['cliente'] }}</td>
                                      <td>{{ number_format($clienteData['porcentajeErrorProceso'], 2) }}%</td>
                                      <td>{{ number_format($clienteData['porcentajeErrorAQL'], 2) }}%</td>
                                  </tr>
                              @endforeach
                          </tbody>
                          <tr style="background: #ddd">
                            <td>GENERAL</td>
                            <td>{{ number_format($totalPorcentajeErrorProceso, 2) }}%</td>
                            <td>{{ number_format($totalPorcentajeErrorAQL, 2) }}%</td>
                          </tr>
                      </table>
                  </div>
                </div>
                <hr> <hr>
                <!-- Sección de Módulos -->
                <div id="modulos" class="section"  >
                  <div class="container-fluid">
                    <table id="tablaDinamico3" class="table table-bordered">
                      <h3 style="text-align: left">Modulo (AQL) &nbsp;<i class="material-icons">view_in_ar</i></h3>
                      <thead class="thead-custom2 text-center">
                          <tr>
                              <th>Modulo (AQL)</th>
                              <th>Numero de Operarios</th>
                              <th>Cantidad Paro</th>
                              <th>Minutos Paro</th>
                              <th>Promedio Minutos Paro</th>
                              <th>Cantidad Paro Modular</th>
                              <th>% Error AQL</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($dataModuloAQL as $item)
                              <tr>
                                  <td>{{ $item['modulo'] }}</td> 
                                  <td>{{ $item['conteoOperario'] }}</td> 
                                  <td>{{ $item['conteoMinutos'] }}</td>
                                  <td>{{ $item['sumaMinutos'] }}</td>
                                  <td>{{ $item['promedioMinutosEntero'] }}</td> 
                                  <td>{{ $item['conteParoModular'] }}</td> 
                                  <td>{{ number_format($item['porcentaje_error_aql'], 2) }}%</td>
                              </tr>
                          @endforeach
                      </tbody>
                    </table>
                    <table id="tablaDinamico4" class="table table-bordered">
                      <h3 style="text-align: left">Modulo (Proceso) &nbsp;<i class="material-icons">cable</i></h3>
                      <thead class="thead-proceso text-center">
                          <tr>
                              <th>Modulo (Proceso)</th>
                              <th>Numero de Operarios</th>
                              <th>Numero de Utility</th>
                              <th>Cantidad Paro</th>
                              <th>Minutos Paro</th>
                              <th>Promedio Minutos Paro</th>
                              <th>% Error Proceso</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($dataModuloProceso as $item)
                              <tr>
                                  <td>{{ $item['modulo'] }}</td>
                                  <td>{{ $item['conteoOperario'] }}</td>
                                  <td>{{ $item['conteoUtility'] }}</td>
                                  <td>{{ $item['conteoMinutos'] }}</td>
                                  <td>{{ $item['sumaMinutos'] }}</td>
                                  <td>{{ $item['promedioMinutosEntero'] }}</td>
                                  <td>{{ number_format($item['porcentaje_error_proceso'], 2) }}%</td>
                              </tr>
                          @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
                <hr> <hr>
                <!-- Sección de Gerentes de Producción -->
                <div id="gerentes" class="section"  >
                  <div class="container-fluid">
                    <table id="tablaDinamico" class="table table-bordered">
                      <h3 style="text-align: left">Gerentes Produccion (AQL) &nbsp;<i class="material-icons">view_in_ar</i></h3>
                      <thead class="thead-custom2 text-center">
                          <tr>
                              <th>Gerentes Produccion (AQL)</th>
                              <th>Cantidad de Módulos</th>
                              <th>Numero de Operarios</th>
                              <th>Cantidad Paro</th>
                              <th>Minutos Paro</th>
                              <th>Promedio Minutos Paro</th>
                              <th>Cantidad Paro Modular</th>
                              <th>% Error AQL</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($dataAQL as $item)
                              <tr>
                                  <td>{{ $item['team_leader'] }}</td>
                                  <td>{{ $item['modulos_unicos'] }}</td> 
                                  <td>{{ $item['conteoOperario'] }}</td> 
                                  <td>{{ $item['conteoMinutos'] }}</td>
                                  <td>{{ $item['sumaMinutos'] }}</td>
                                  <td>{{ $item['promedioMinutosEntero'] }}</td> 
                                  <td>{{ $item['conteParoModular'] }}</td> 
                                  <td>{{ number_format($item['porcentaje_error_aql'], 2) }}%</td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                  <table id="tablaDinamico2" class="table table-bordered">
                      <h3 style="text-align: left">Gerentes Produccion (Proceso) &nbsp;<i class="material-icons">cable</i></h3>
                      <thead class="thead-proceso text-center">
                          <tr>
                              <th>Gerentes Produccion (Proceso)</th>
                              <th>Cantidad de Módulos</th>
                              <th>Numero de Operarios</th>
                              <th>Numero de Utility</th>
                              <th>Cantidad Paro</th>
                              <th>Minutos Paro</th>
                              <th>Promedio Minutos Paro</th>
                              <th>% Error Proceso</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($dataProceso as $item)
                              <tr>
                                  <td>{{ $item['team_leader'] }}</td>
                                  <td>{{ $item['modulos_unicos'] }}</td>
                                  <td>{{ $item['conteoOperario'] }}</td>
                                  <td>{{ $item['conteoUtility'] }}</td>
                                  <td>{{ $item['conteoMinutos'] }}</td>
                                  <td>{{ $item['sumaMinutos'] }}</td>
                                  <td>{{ $item['promedioMinutosEntero'] }}</td>
                                  <td>{{ number_format($item['porcentaje_error_proceso'], 2) }}%</td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
       
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

    /* Personalizar estilo del thead */
    .thead-custom2 {
            background-color: #0891ec; /* Ajusta el color hexadecimal a tu gusto */
            color: #fff; /* Ajusta el color del texto si es necesario */
            border: 1px solid #ddd; /* Ajusta el borde si es necesario */
            padding: 10px; /* Ajusta el relleno si es necesario */
        }
    .thead-cliente {
            background-color: #ca600a; /* Ajusta el color hexadecimal a tu gusto */
            color: #fff; /* Ajusta el color del texto si es necesario */
            border: 1px solid #ddd; /* Ajusta el borde si es necesario */
            padding: 10px; /* Ajusta el relleno si es necesario */
        }
    .thead-proceso {
            background-color: #DB2164; /* Ajusta el color hexadecimal a tu gusto */
            color: #fff; /* Ajusta el color del texto si es necesario */
            border: 1px solid #ddd; /* Ajusta el borde si es necesario */
            padding: 10px; /* Ajusta el relleno si es necesario */
        } 

    #comparativeChartProceso {
        width: 150px !important;
        height: 150px !important;
      }
  </style>
@endsection

@push('js')


    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">


    <!-- DataTables JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <!-- canvas char -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>

  <script>
    function showSection(sectionId) {
        // Ocultar todas las secciones
        var sections = document.getElementsByClassName('section');
        for (var i = 0; i < sections.length; i++) {
            sections[i].style.display = 'none';
        }
    
        // Mostrar la sección seleccionada
        document.getElementById(sectionId).style.display = 'block';
    }
    </script>

  <script>
    $(document).ready(function() {
        $('#tablaDinamico').DataTable({
          lengthChange: false,
          searching: false,
          paging: true,
          pageLength: 10,
          autoWidth: false,
          responsive: true,
      });
    });
    

    $(document).ready(function() {
        $('#tablaClientes').DataTable({
          lengthChange: false,
          searching: false,
          paging: true,
          pageLength: 10,
          autoWidth: false,
          responsive: true,
          //columnDefs: [
              //{ orderable: false, targets: [1, 2, 3] } // Aquí deshabilitas la ordenación para las columnas 2, 3 y 4 (índices 1, 2, 3)
          //]
      });
    });

    $(document).ready(function() {
        $('#tablaDinamico2').DataTable({
          lengthChange: false,
          searching: false,
          paging: true,
          pageLength: 10,
          autoWidth: false,
          responsive: true,
      });
    });
    $(document).ready(function() {
        $('#tablaDinamico3').DataTable({
          lengthChange: false,
          searching: false,
          paging: true,
          pageLength: 10,
          autoWidth: false,
          responsive: true,
      });
    });
    $(document).ready(function() {
        $('#tablaDinamico4').DataTable({
          lengthChange: false,
          searching: false,
          paging: true,
          pageLength: 10,
          autoWidth: false,
          responsive: true,
      });
    });
  </script> 

  <script>
    var ctx = document.getElementById('comparativeChart').getContext('2d');
    var comparativeChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Planta Ixtlahuaca', 'Planta San Bartolo'],
            datasets: [{
                label: 'Comparativa de porcentajes',
                data: [{{$generalAQLPlanta1}}, {{$generalAQLPlanta2}}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctx = document.getElementById('comparativeChartProceso').getContext('2d');
    var comparativeChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Planta Ixtlahuaca', 'Planta San Bartolo'],
        datasets: [{
          label: 'Comparativa de porcentajes',
          data: [{{$generalProcesoPlanta1}}, {{$generalProcesoPlanta2}}],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)'
          ],
          borderWidth: 1,
          // Opciones adicionales para gráficos circulares
          weight: [{{$generalProcesoPlanta1}}, {{$generalProcesoPlanta2}}], // Asigna pesos a los datos
          position: 'edge' // Ajusta la posición de las etiquetas
        }]
      },
      options: {
        responsive: false, // Desactiva el redimensionamiento automático
        maintainAspectRatio: false // Desactiva la relación de aspecto mantenida
        // ... opciones de Chart.js
      }
    });
  </script>
  
@endpush
