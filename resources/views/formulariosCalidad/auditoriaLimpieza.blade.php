@extends('layouts.app', ['activePage' => 'Auditoria Limpieza', 'titlePage' => __('Auditoria Limpieza')])

@section('content')
     {{-- ... dentro de tu vista ... --}}
     @if(session('error'))
     <div class="alert alert-danger">
         {{ session('error') }}
     </div>
     @endif
     @if(session('success'))
     <div class="alert alerta-exito">
         {{ session('success') }}
         @if(session('sorteo'))
             <br>{{ session('sorteo') }}
         @endif
     </div>
     @endif
     @if(session('status')) {{-- A menudo utilizado para mensajes de estado genéricos --}}
         <div class="alert alert-secondary">
             {{ session('status') }}
         </div>
     @endif
     <style>
     .alerta-exito {
         background-color: #28a745; /* Color de fondo verde */
         color: white; /* Color de texto blanco */
         padding: 20px;
         border-radius: 15px;
         font-size: 20px;
     }
     </style>
     {{-- ... el resto de tu vista ... --}}
     <div class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header card-header-primary">
                <h3 class="card-title">CHECK LIST DE AUDITORIA DE LIMPIEZA Y PPP</h3>
              </div>
                         <form method="POST" action="{{ route('formulariosCalidad.formAuditoriaCortes') }}">
                             @csrf
                             <hr>
                             <div class="card-body">
                                 <!--Desde aqui inicia la edicion del codigo para mostrar el contenido-->
                                 <div class="row">
                                     <div class="col-md-6 mb-3">
                                         <label for="nombre" class="col-sm-3 col-form-label">Fecha</label>
                                         <div class="col-sm-12 d-flex justify-content-between align-items-center">
                                             <p>{{ now()->format('d ') . $mesesEnEspanol[now()->format('n') - 1] . now()->format(' Y') }}</p>
                                             <p class="ml-auto">Dia: {{$nombreDia}}</p>
                                         </div>
                                     </div>
                                     <div class="col-md-6 mb-3">
                                         <label for="nombre" class="col-sm-3 col-form-label">AUDITOR</label>
                                         <div class="col-sm-12 d-flex align-items-center">
                                             <select name="nombre" id="nombre" class="form-control" required title="Por favor, selecciona una opción">
                                                 <option value="">Selecciona una opción</option>
                                                 @foreach ($CategoriaAuditor as $auditor)
                                                     <option value="{{ $auditor->id }}">{{ $auditor->nombre }}</option>
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>
                                     <div class="col-md-6 mb-3">
                                         <label for="color" class="col-sm-3 col-form-label">COLOR</label>
                                         <div class="col-sm-12">
                                             <input type="number" class="form-control" name="color" id="color" placeholder="..." required />
                                         </div>
                                     </div>
                                     <div class="col-md-6 mb-3">
                                         <label for="nombre" class="col-sm-3 col-form-label">TEAM-LEADER</label>
                                         <div class="col-sm-12 d-flex align-items-center">
                                             <select name="nombre" id="nombre" class="form-control" required title="Por favor, selecciona una opción">
                                                 <option value="">Selecciona una opción</option>
                                                 @foreach ($CategoriaAuditor as $auditor)
                                                     <option value="{{ $auditor->id }}">{{ $auditor->nombre }}</option>
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>
                                     <div class="col-md-6 mb-3">
                                         <label for="lienzo" class="col-sm-6 col-form-label"># DE ESTILO DESCRIPCION</label>
                                         <div class="col-sm-12">
                                             <input type="text" class="form-control" name="lienzo" id="lienzo" placeholder="..." required />
                                         </div>
                                     </div>
                                 </div>
                                 <hr>
                                 <div style="background: #32d2d8a2">
                                     <h4 style="text-align: center"> - - - - </h4>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-6 mb-3">
                                         <label for="operario" class="col-sm-3 col-form-label">OPERARIO</label>
                                         <div class="col-sm-12 d-flex align-items-center">
                                             <select name="operario" id="operario" class="form-control" required title="Por favor, selecciona una opción">
                                                 <option value="">Selecciona una opción</option>
                                                 @foreach ($CategoriaAuditor as $auditor)
                                                     <option value="{{ $auditor->id }}">{{ $auditor->nombre }}</option>
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>
                                     <div class="col-md-6 mb-3">
                                         <label for="tipo_maquina" class="col-sm-3 col-form-label">TIPO DE MAQUINA</label>
                                         <div class="col-sm-12 d-flex align-items-center">
                                             <select name="tipo_maquina" id="tipo_maquina" class="form-control" required title="Por favor, selecciona una opción">
                                                 <option value="">Selecciona una opción</option>
                                                 @foreach ($CategoriaAuditor as $auditor)
                                                     <option value="{{ $auditor->id }}">{{ $auditor->nombre }}</option>
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>
                                     <div class="col-md-6 mb-3">
                                         <label for="operacion" class="col-sm-3 col-form-label">OPERACION</label>
                                         <div class="col-sm-12 d-flex align-items-center">
                                             <select name="operacion" id="operacion" class="form-control" required title="Por favor, selecciona una opción">
                                                 <option value="">Selecciona una opción</option>
                                                 @foreach ($CategoriaEstilo as $operacion)
                                                     <option value="{{ $operacion->id }}">{{ $operacion->nombre }}</option>
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>
                                     <hr>
                                 </div>
                                 <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                 <!--Fin de la edicion del codigo para mostrar el contenido-->
                             </div>
                         <form>
                     </div>
                 </div>
             </div>
 @endsection
