@extends('layouts.app', ['activePage' => 'Etiquetas', 'titlePage' => __('Etiquetas')])

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
    {{-- ... el resto de tu vista ... --}}
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <!--Aqui se edita el encabezado que es el que se muestra -->
                <div class="card-header card-header-primary">
                    <h3 class="card-title">AUDITORIA DE ETIQUETAS</h3>
                    Fecha: {{ now()->format('d ') . $mesesEnEspanol[now()->format('n') - 1] . now()->format(' Y') }}
                </div>
                <form method="POST" action="{{ route('formulariosCalidad.formAuditoriaEtiquetas') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-left">
                                <a href="#" class="btn btn-sm btn-info" id="tblInsbtn" data-toggle="modal"
                                    data-target="#myModal">
                                    Tabla Inspección Normal
                                    <label for="name" id="table" class="material-icons">table_view</label>
                                </a>
                            </div>
                        </div>
                        <div>
                            <div class="row mb-3">
                                <label for="cliente" class="col-sm-3 col-form-label">CLIENTE:</label>
                                <div class="col-sm-9">
                                    <select name="cliente" id="cliente" class="form-control" required
                                        title="Por favor, selecciona una opción">
                                        <option value="">Selecciona una opción</option>
                                        @foreach ($CategoriaCliente as $cliente)
                                            <option value="{{ $cliente->id }}"
                                                {{ old('cliente') == $cliente->id ? 'selected' : '' }}>
                                                {{ $cliente->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="estilo" class="col-sm-3 col-form-label">ESTILO</label>
                                <div class="col-sm-9">
                                    <select name="estilo" id="estilo" class="form-control" required
                                        title="Por favor, selecciona una opción">
                                        <option value="">Selecciona una opción</option>
                                        @foreach ($CategoriaEstilo as $estilo)
                                            <option value="{{ $estilo->id }}"
                                                {{ old('estilo') == $estilo->id ? 'selected' : '' }}>{{ $estilo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="no_recibo" class="col-sm-3 col-form-label">NO/RECIBO</label>
                                <div class="col-sm-9">
                                    <select name="no_recibo" id="no_recibo" class="form-control" required
                                        title="Por favor, selecciona una opción">
                                        <option value="">Selecciona una opción</option>
                                        @foreach ($CategoriaNoRecibo as $no_recibo)
                                            <option value="{{ $no_recibo->id }}">{{ $no_recibo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="talla_cantidad" class="col-sm-3 col-form-label">TALLA/CANTIDAD</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="talla_cantidad" id="talla_cantidad"
                                        placeholder="Ingresa talla " required title="Por favor, selecciona una opción"
                                        oninput="this.value = this.value.toUpperCase()">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="muestra" class="col-sm-3 col-form-label">TAMAÑO DE MUESTRA</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="muestra" id="muestra"
                                        placeholder="Ingresa Tamaño de Muestra" required
                                        title="Por favor, selecciona una opción" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="defecto" class="col-sm-3 col-form-label">DEFECTOS</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="defecto" id="defecto"
                                        placeholder="Ingresa Defecto" title="Por favor, selecciona una opción" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="tipo_defecto" class="col-sm-3 col-form-label">TIPO DE DEFECTO</label>
                                <div class="col-sm-9">
                                    <select name="tipo_defecto" id="tipo_defecto" class="form-control" required
                                        title="Por favor, selecciona una opción">
                                        <option value="">Selecciona una opción</option>
                                        @foreach ($CategoriaTipoDefecto as $tipo_defecto)
                                            <option value="{{ $tipo_defecto->id }}">{{ $tipo_defecto->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <label class="col-form-label-radio">
                                <input type="radio" name="estado" value="1" required>
                                Aprobado
                            </label>
                            <label class="col-form-label-radio">
                                <input type="radio" name="estado" value="0" required>
                                Rechazado
                            </label>
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        <!--Fin de la edicion del codigo para mostrar el contenido-->
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-header card-header-primary" id="exampleModalLabel">TABLA PARA INSPECCIONJ NORMAL:
                        MUESTREO SIMPLE (MIL STD 105E)
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <i class="material-icons">search</i>
                    <input type="number" id="searchInput" class="form-control" placeholder="Buscar Tamaño de Lote">
                    <!-- Contenido del modal -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Tamaño de Lote</th>
                                    <th>Nivel General de inspección II</th>
                                    <th>Letra Código para el tamaño de muestra</th>
                                    <th>Tamaño de Muestra</th>
                                    <th>Aprobado</th>
                                    <th>Rechazado</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <tr class="table-row">
                                    <td>2 a 8</td>
                                    <td>A</td>
                                    <td>A</td>
                                    <td class="muestra-size">2</td>
                                    <td>/</td>
                                    <td>/</td>
                                </tr>
                                <tr class="table-row">
                                    <td>9 a 15</td>
                                    <td>B</td>
                                    <td>B</td>
                                    <td class="muestra-size">3</td>
                                    <td>/</td>
                                    <td>/</td>
                                </tr>
                                <tr class="table-row">
                                    <td>16 a 25</td>
                                    <td>C</td>
                                    <td>C</td>
                                    <td class="muestra-size">5</td>
                                    <td>/</td>
                                    <td>/</td>
                                </tr>
                                <tr class="table-row">
                                    <td>26 a 50</td>
                                    <td>D</td>
                                    <td>D</td>
                                    <td class="muestra-size">8</td>
                                    <td>0</td>
                                    <td>1</td>
                                </tr>
                                <tr class="table-row">
                                    <td>51 a 90</td>
                                    <td>E</td>
                                    <td>E</td>
                                    <td class="muestra-size">13</td>
                                    <td>/</td>
                                    <td>/</td>
                                </tr>
                                <tr class="table-row">
                                    <td>91 a 150</td>
                                    <td>F</td>
                                    <td>F</td>
                                    <td class="muestra-size">20</td>
                                    <td>1</td>
                                    <td>2</td>
                                </tr>
                                <tr class="table-row">
                                    <td>151 a 280</td>
                                    <td>G</td>
                                    <td>G</td>
                                    <td class="muestra-size">32</td>
                                    <td>/</td>
                                    <td>/</td>
                                </tr>
                                <tr class="table-row">
                                    <td>281 a 500</td>
                                    <td>H</td>
                                    <td>H</td>
                                    <td class="muestra-size">50</td>
                                    <td>2</td>
                                    <td>3</td>
                                </tr>
                                <tr class="table-row">
                                    <td>501 a 1200</td>
                                    <td>J</td>
                                    <td>J</td>
                                    <td class="muestra-size">80</td>
                                    <td>3</td>
                                    <td>4</td>
                                </tr>
                                <tr class="table-row">
                                    <td>1201 a 3200</td>
                                    <td>K</td>
                                    <td>K</td>
                                    <td class="muestra-size">125</td>
                                    <td>5</td>
                                    <td>6</td>
                                </tr>
                                <tr class="table-row">
                                    <td>3201 a 10000</td>
                                    <td>L</td>
                                    <td>L</td>
                                    <td class="muestra-size">200</td>
                                    <td>7</td>
                                    <td>8</td>
                                </tr>
                                <tr class="table-row">
                                    <td>10000 a 35000</td>
                                    <td>M</td>
                                    <td>M</td>
                                    <td class="muestra-size">315</td>
                                    <td>10</td>
                                    <td>11</td>
                                </tr>
                                <tr class="table-row">
                                    <td>35000 a 150000</td>
                                    <td>N</td>
                                    <td>N</td>
                                    <td class="muestra-size">500</td>
                                    <td>14</td>
                                    <td>15</td>
                                </tr>
                                <tr class="table-row">
                                    <td>150000 a 5000000</td>
                                    <td>P</td>
                                    <td>P</td>
                                    <td class="muestra-size">800</td>
                                    <td>21</td>
                                    <td>22</td>
                                </tr>
                                <tr class="table-row">
                                    <td>5000000 o más</td>
                                    <td>Q</td>
                                    <td>Q</td>
                                    <td class="muestra-size">2000</td>
                                    <td>/</td>
                                    <td>/</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <!-- Otros botones si es necesario -->
                </div>
            </div>
        </div>
    </div>

    <style>
        .modal-dialog {
            max-width: 80%;
            /* Ajusta el ancho del modal según tus necesidades */
            max-height: 100%;
            /* Ajusta el ancho del modal según tus necesidades */
        }

        .modal-body {
            max-height: 70vh;
            /* Ajusta la altura máxima según tus necesidades */
            overflow-y: auto;
            /* Permite el desplazamiento vertical si el contenido es más grande que la altura máxima */
            overflow-x: auto;
            /* Permite el desplazamiento horizontal */
        }

        .table-responsive {
            display: block;
            max-width: 100%;
            overflow-x: auto;
            -ms-overflow-style: -ms-autohiding-scrollbar;
        }
    </style>

    <style>
        .selected-row {
            background-color: #11d885ef;
            /* Cambia este color al que prefieras */
        }
    </style>
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            var filterValue = this.value.toLowerCase();
            var rows = document.getElementById('tableBody').getElementsByTagName('tr');

            for (var i = 0; i < rows.length; i++) {
                var tamañoLoteCell = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
                // Comprueba si la celda contiene "o más"
                if (tamañoLoteCell.includes('o más')) {
                    // Extrae el número antes de " o más"
                    var numberBeforeText = parseInt(tamañoLoteCell.split(' ')[0], 10);
                    var filterNumber = parseInt(filterValue, 10);
                    if (!isNaN(filterNumber) && filterNumber > numberBeforeText) {
                        rows[i].style.display = '';
                        continue;
                    }
                }
                // Si no contiene "o más", maneja como un rango
                else {
                    var rangeParts = tamañoLoteCell.split(' a ');
                    if (rangeParts.length === 2) {
                        var rangeStart = parseInt(rangeParts[0], 10);
                        var rangeEnd = parseInt(rangeParts[1], 10);
                        var filterNumber = parseInt(filterValue, 10);
                        if (!isNaN(filterNumber) && filterNumber >= rangeStart && filterNumber <= rangeEnd) {
                            rows[i].style.display = '';
                            continue;
                        }
                    }
                }
                rows[i].style.display = 'none';
            }
        });


        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('#tableBody .table-row').forEach(row => {
                row.addEventListener('click', function() {
                    // Quita la clase 'selected-row' de todas las filas
                    document.querySelectorAll('.selected-row').forEach(selectedRow => {
                        selectedRow.classList.remove('selected-row');
                    });

                    // Agrega la clase 'selected-row' a la fila clickeada
                    this.classList.add('selected-row');

                    // Obtén el texto del tamaño de muestra de la celda correspondiente
                    let tamañoMuestra = this.querySelector('.muestra-size').textContent;
                    // Asigna ese texto al input del tamaño de muestra
                    document.getElementById('muestra').value = tamañoMuestra;
                    // Cierra el modal utilizando la API de modal de Bootstrap 5
                    let modalElement = document.getElementById('miModal');
                    if (modalElement) {
                        let modalInstance = bootstrap.Modal.getInstance(modalElement);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    }
                });
            });
        });
    </script>
@endsection
