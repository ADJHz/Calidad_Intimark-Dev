<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Intimark-Calidad') }}</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/Intimark.ico">
    <link rel="icon" type="image/ico" href="{{ asset('material') }}/img/Intimark.ico">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.3" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('material') }}/demo/demo.css" rel="stylesheet" />
</head>


<body class="clickup-chrome-ext_installed">
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <input type="hidden" name="_token" value="NKN81BvuQSzEbJlULUVrTDRewUlcAIJhPbOwli18"> </form>
    <div class="wrapper ">
        <div class="sidebar" data-color="green" data-background-color="white"
            data-image="{{ asset('material') }}/img/sidebar-1.jpg">
            <!--
                Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

                Tip 2: you can also add an image using data-image tag
            -->
            <div class="logo">
                <i><img style="width:150px" src="{{ asset('material') }}/img/Intimark.png"></i>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    @if (auth()->check() && (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Gerente de Calidad')))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">
                                <i class="material-icons">dashboard</i>
                                <p>{{ __('Dashboard') }}</p>
                            </a>
                    @endif
                    </li>
                    @if (auth()->check() && (auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Gerente de Calidad')))
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
                                <i class="material-icons">admin_panel_settings</i>
                                <p>{{ __('Admin cuentas') }}
                                    <b class="caret"></b>
                                </p>
                            </a>
                            <div class="collapse" id="laravelExample">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('profile.edit') }}">
                                            <span class="sidebar-mini"> UP </span>
                                            <span class="sidebar-normal">{{ __('User profile') }} </span>
                                        </a>
                                    </li>
                                    <li class="nav-item active">
                                        <a class="nav-link" href="{{ route('user.index') }}">
                                            <span class="sidebar-mini"> UM </span>
                                            <span class="sidebar-normal"> {{ __('User Management') }} </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#laravelExamples" aria-expanded="true">
                            <i class="material-icons">note_alt</i>
                            <p>{{ __('Formularios Calidad') }}
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="laravelExamples">
                            <ul class="nav">
                 @if (auth()->check() && (auth()->user()->hasRole('Auditor') || auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Gerente de Calidad')) && auth()->user()->Planta == 'Planta1')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('formulariosCalidad.auditoriaEtiquetas') }}">
                                        <i class="material-icons">edit_document</i>
                                        <p>{{ __('FCC-014') }}</p>
                                        <p style="text-align: center;">{{ __('AUDITORIA ETIQUETAS') }}</p>

                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('formulariosCalidad.auditoriaCortes') }}">
                                        <i class="material-icons">edit_document</i>
                                        <p>{{ __('FCC-010') }}</p>
                                        <p style="text-align: center;">{{ __('AUDITORIA CORTE') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('formulariosCalidad.evaluacionCorte') }}">
                                        <i class="material-icons">edit_document</i>
                                        <p>{{ __('F-4') }}</p>
                                        <p style="text-align: center;">{{ __('EVALUACION DE CORTE') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">

                                        <i class="material-icons">edit_document</i>
                                        <p>{{ __('FCC-010') }}</p>
                                        <p style="text-align: center;">{{ __('AUDITORIA FINAL A.Q.L') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">

                                        <i class="material-icons">edit_document</i>
                                        <p>{{ __('FCC-010') }}</p>
                                        <p style="text-align: center;">{{ __('CONTROL DE CALIDAD EMPAQUE') }}</p>
                                    </a>
                                </li>
                                @endif
 @if (auth()->check() && (auth()->user()->hasRole('Auditor') || auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Gerente de Calidad')) && auth()->user()->Planta == 'Planta2')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('ScreenPlanta2.ScreenPrint') }}">
                                        <i class="material-icons">edit_document</i>
                                        <p>{{ __('Screen Print') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('ScreenPlanta2.InsEstamHorno') }}">
                                        <i class="material-icons">edit_document</i>
                                        <p>{{ __('Inspección Después De Horno') }}</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('ScreenPlanta2.CalidadProcesoPlancha') }}">
                                        <i class="material-icons">edit_document</i>
                                        <p>{{ __('Proceso Plancha') }}</p>
                                    </a>
                                </li>
                                @endif
                    </li>
                </ul>
            </div>
            </li>
            </ul>
        </div>
    </div>
    <div class="main-panel">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
            <div class="container-fluid">
                <div class="navbar-wrapper">
                    <a class="navbar-brand" href="#">User Management</a>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                    <span class="navbar-toggler-icon icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">person</i>
                                <p class="d-lg-none d-md-block">
                                    Account
                                </p>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">Log
                                    out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div id="messages-container" class="container mt-5">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="card-header card-header-primary">
                                <h4 class="card-title ">Users</h4>
                                <p class="card-category"> Here you can manage users</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 text-right">

                                        <a href="#" class="btn btn-sm btn-primary " id="addUserBtn">
                                            Add
                                            user
                                            <label for="name" class="material-icons">
                                                person_add</label></a>
                                    </div>
                                </div>
                                <div class="card-body table-responsive">
                                    <table class="table table-hover">
                                        <thead class=" text-primary">
                                            <tr>
                                                <th>
                                                    Name
                                                </th>
                                                <th>
                                                    No. Empleado
                                                </th>
                                                <th>
                                                    Email
                                                </th>
                                                <th>
                                                    Auditor
                                                </th>
                                                <th>
                                                    Puesto
                                                </th>
                                                <th>
                                                    Creation date
                                                </th>
                                                <th>
                                                    Status User
                                                </th>
                                                <th class="text-right">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->no_empleado }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->tipo_auditor }}</td>
                                                    <td>{{ $user->puesto }}</td>
                                                    <td>{{ $user->created_at }}</td>
                                                    <td>{{ $user->Estatus }}</td>
                                                    <td class="td-actions text-right">
                                                        <div class="btn-group" role="group" aria-label="Acciones">
                                                            <button class="btn btn-info btn-link editUserBtn"
                                                                data-id="{{ $user->no_empleado }}"
                                                                data-name="{{ $user->name }}">
                                                                <i class="material-icons">edit</i>
                                                            </button>
                                                            <form method="POST"
                                                                action="{{ route('blockUser', ['noEmpleado' => $user->no_empleado]) }}">
                                                                @method('PUT')
                                                                @csrf
                                                                <!-- Resto de tus campos y botones aquí -->
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-link">
                                                                    @if ($user->Estatus == 'Baja')
                                                                        <i class="material-icons">block</i>
                                                                </button>
                                                            @else
                                                                <button type="submit"
                                                                    class="btn btn-success btn-link">
                                                                    <i class="material-icons">how_to_reg</i>
                                            @endif
                                            </button>
                                            </form>
                                </div>
                                </td>
                                </tr>
                                @endforeach
                                </tbody>
                                </table>
                                <!-- Modal -->
                                <form id="addUserForm" action="{{ route('user.AddUser') }}" method="POST">
                                    @csrf
                                    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog"
                                        aria-labelledby="addUserModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="card-header card-header-primary"
                                                        id="addUserModalLabel">Add User
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name" class="material-icons">
                                                            person</label>
                                                        <input type="text" class="form-control" name="name"
                                                            id="name" placeholder="Enter name" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email" class="material-icons">mail</label>
                                                        <input type="email" class="form-control" name="email"
                                                            id="email" placeholder="Enter email" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="no_empleado"
                                                            class="material-icons">numbers</label>
                                                        <input type="number" class="form-control" name="no_empleado"
                                                            id="no_empleado" placeholder="Enter no. empleado"
                                                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                            maxlength="10" required>
                                                    </div>
                                                    <div class="form-group row">
                                                        <span class="material-icons">key</span>
                                                        <label for="password" class="col-sm-2 col-form-label">
                                                        </label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="password" class="form-control"
                                                                    name="password" id="password"
                                                                    placeholder="Enter password" required>
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text show-password-toggle"
                                                                        style="cursor: pointer;"
                                                                        onclick="togglePasswordVisibility('password')">
                                                                        <i
                                                                            class="material-icons">visibility</i>{{ __('Ver') }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="tipo_auditoria"
                                                            class="material-icons">engineering</label>
                                                        <select class="form-control" id="tipo_auditoria"
                                                            name="tipo_auditoria" required>
                                                            <!-- Las opciones se cargarán dinámicamente aquí -->
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="editPuesto" class="material-icons">work</label>
                                                        <select class="form-control" id="editPuesto"
                                                            name="editPuesto" required>
                                                            <!-- Las opciones se cargarán dinámicamente aquí -->
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="editPlanta"
                                                            class="material-icons">apartment</label>
                                                        <select class="form-control" id="editPlanta"
                                                            name="editPlanta" required>
                                                            <option value="" disabled selected hidden>
                                                                Seleccione la planta </option>
                                                            <option value="Planta1">Ixtlahuaca </option>
                                                            <option value="Planta2">San Bartolo</option>
                                                        </select>
                                                    </div>
                                                    <!-- Otros campos del formulario según tus necesidades -->
                                                    <button type="submit" class="bookmarkBtn">
                                                        <span class="IconContainer">
                                                            <svg viewBox="0 0 384 512" height="0.9em" class="icon">
                                                                <path
                                                                    d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z">
                                                                </path>
                                                            </svg>
                                                        </span>
                                                        <p class="text">Save</p>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form id="editUser" action="{{ route('users.editUser') }}" method="POST">
                                    @csrf
                                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                                        aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <!-- Contenido del modal, puedes personalizarlo según tus necesidades -->
                                                <div class="modal-header">
                                                    <h5 class="card-header card-header-primary" id="editModalLabel">
                                                        Editar Usuario</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Campos de edición -->
                                                    <div class="form-group">
                                                        <label for="editId" class="material-icons">badge</label>
                                                        <input type="text" class="form-control disabled-input"
                                                            name="editId" id="editId">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="editName" class="material-icons">person</label>
                                                        <input type="text" class="form-control" name="editName"
                                                            id="editName" placeholder="Nombre del usuario">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="editTipoAuditoria"
                                                            class="material-icons">engineering</label>
                                                        <select class="form-control" id="editTipoAuditoria"
                                                            name="editTipoAuditoria">
                                                            <!-- Las opciones se cargarán dinámicamente aquí -->
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="editPuestos" class="material-icons">work</label>
                                                        <select class="form-control" id="editPuestos"
                                                            name="editPuestos">
                                                            <!-- Las opciones se cargarán dinámicamente aquí -->
                                                        </select>
                                                    </div>
                                                    <div class="form-group row">
                                                        <span class="material-icons">lock_reset</span>
                                                        <label for="password" class="col-sm-2 col-form-label"></label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="password" class="form-control"
                                                                    name="password_update" id="password_update"
                                                                    placeholder="Cambiar Contraseña">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text show-password-toggle"
                                                                        style="cursor: pointer;"
                                                                        onclick="togglePasswordVisibility('password_update')">
                                                                        <i
                                                                            class="material-icons">visibility</i>{{ __('Ver') }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Otros campos según sea necesario -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="bookmarkBtn">
                                                        <span class="IconContainer">
                                                            <svg viewBox="0 0 384 512" height="0.9em" class="icon">
                                                                <path
                                                                    d="M0 48V487.7C0 501.1 10.9 512 24.3 512c5 0 9.9-1.5 14-4.4L192 400 345.7 507.6c4.1 2.9 9 4.4 14 4.4c13.4 0 24.3-10.9 24.3-24.3V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48z">
                                                                </path>
                                                            </svg>
                                                        </span>
                                                        <p class="text">Save</p>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>

    <!--   Core JS Files   -->
    <script src="{{ asset('material') }}/js/core/jquery.min.js"></script>
    <script src="{{ asset('material') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('material') }}/js/core/bootstrap-material-design.min.js"></script>
    <script src="{{ asset('material') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!-- Plugin for the momentJs  -->
    <script src="{{ asset('material') }}/js/plugins/moment.min.js"></script>
    <!--  Plugin for Sweet Alert -->
    <script src="{{ asset('material') }}/js/plugins/sweetalert2.js"></script>
    <!-- Forms Validations Plugin -->
    <script src="{{ asset('material') }}/js/plugins/jquery.validate.min.js"></script>
    <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="{{ asset('material') }}/js/plugins/jquery.bootstrap-wizard.js"></script>
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="{{ asset('material') }}/js/plugins/bootstrap-selectpicker.js"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="{{ asset('material') }}/js/plugins/bootstrap-datetimepicker.min.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="{{ asset('material') }}/js/plugins/jquery.dataTables.min.js"></script>
    <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="{{ asset('material') }}/js/plugins/bootstrap-tagsinput.js"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="{{ asset('material') }}/js/plugins/jasny-bootstrap.min.js"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="{{ asset('material') }}/js/plugins/fullcalendar.min.js"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="{{ asset('material') }}/js/plugins/jquery-jvectormap.js"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="{{ asset('material') }}/js/plugins/nouislider.min.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!-- Library for adding dinamically elements -->
    <script src="{{ asset('material') }}/js/plugins/arrive.min.js"></script>
    <!-- Chartist JS -->
    <script src="{{ asset('material') }}/js/plugins/chartist.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('material') }}/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('material') }}/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{ asset('material') }}/demo/demo.js"></script>
    <script src="{{ asset('material') }}/js/settings.js"></script>

    <script>
        $(document).ready(function() {
            // Mostrar el modal al hacer clic en el botón "Add user"
            $("#addUserBtn").click(function() {
                $("#addUserModal").modal("show");
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Deshabilitar visualmente los campos editId, editName y editTipoAuditoria
            $("#editId, #editName").addClass("disabled-input").attr("readonly", true).css("pointer-events", "none");

            // Mostrar el modal al hacer clic en cualquier botón de edición
            $(".editUserBtn").click(function() {
                // Obtener el ID del usuario desde el atributo data-id
                var userId = $(this).data('id');

                // Asignar el ID al campo editId en el modal
                $("#editId").val(userId);

                // Obtener el nombre del usuario desde el atributo data-name
                var userName = $(this).data('name');

                // Asignar el nombre al campo editName en el modal
                $("#editName").val(userName);

                // Cargar las opciones del tipo de auditoría desde la base de datos
                $.ajax({
                    url: '/tipoAuditorias', // Ajusta la URL según tu ruta
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Limpiar las opciones existentes
                        $('#editTipoAuditoria').empty();
                        // Agregar la opción predeterminada
                        $('#editTipoAuditoria').append($('<option>', {
                            text: 'Enter Auditor',
                            disabled: true,
                            selected: true
                        }));
                        // Agregar las nuevas opciones desde la respuesta del servidor
                        $.each(data, function(key, value) {
                            $('#editTipoAuditoria').append($('<option>', {
                                text: value.Tipo_auditoria
                            }));
                        });
                    },
                    error: function(error) {
                        console.error('Error al cargar opciones: ', error);
                    }
                });

                // Cargar las opciones de los puestos desde la base de datos
                $.ajax({
                    url: '/puestos', // Ajusta la URL según tu ruta
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Limpiar las opciones existentes
                        $('#editPuestos').empty();

                        // Agregar la opción predeterminada
                        $('#editPuestos').append($('<option>', {
                            text: 'Enter puesto',
                            disabled: true,
                            selected: true
                        }));
                        // Agregar las nuevas opciones desde la respuesta del servidor
                        $.each(data, function(key, value) {
                            $('#editPuestos').append($('<option>', {
                                text: value.Puesto
                            }));
                        });
                    },
                    error: function(error) {
                        console.error('Error al cargar opciones de puestos: ', error);
                    }
                });

                // Mostrar el modal de edición
                $("#editModal").modal("show");
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Al abrir el modal, cargar las opciones del dropdown
            $('#addUserModal').on('show.bs.modal', function() {
                $.ajax({
                    url: '/tipoAuditorias',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Limpiar las opciones existentes
                        $('#tipo_auditoria').empty();
                        // Agregar la opción predeterminada
                        $('#tipo_auditoria').append($('<option>', {
                            text: 'Enter puesto',
                            disabled: true,
                            selected: true
                        }));
                        // Agregar las nuevas opciones desde la respuesta del servidor
                        $.each(data, function(key, value) {
                            $('#tipo_auditoria').append($('<option>', {
                                text: value.Tipo_auditoria
                            }));
                        });
                    },
                    error: function(error) {
                        console.error('Error al cargar opciones: ', error);
                    }
                });
                $.ajax({
                    url: '/puestos', // Ajusta la URL según tu ruta
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Limpiar las opciones existentes
                        $('#editPuesto').empty();

                        // Agregar la opción predeterminada
                        $('#editPuesto').append($('<option>', {
                            text: 'Enter puesto',
                            disabled: true,
                            selected: true
                        }));
                        // Agregar las nuevas opciones desde la respuesta del servidor
                        $.each(data, function(key, value) {
                            $('#editPuesto').append($('<option>', {
                                text: value.Puesto
                            }));
                        });
                    },
                    error: function(error) {
                        console.error('Error al cargar opciones de puestos: ', error);
                    }
                });
            });
        });
    </script>
    <script>
        function togglePasswordVisibility(inputId) {
            var passwordInput = document.getElementById(inputId);
            passwordInput.type = (passwordInput.type === 'password') ? 'text' : 'password';
        }
    </script>
    <script>
        function togglePasswordVisibility(inputId) {
            var passwordInput = document.getElementById(inputId);
            passwordInput.type = (passwordInput.type === 'password') ? 'text' : 'password';
        }
    </script>
    <script>
        $(document).ready(function() {
            // Cierra el mensaje cuando se hace clic en el botón de cerrar
            $(".alert").alert();

            // Cierra automáticamente el mensaje después de 5 segundos (puedes ajustar este tiempo)
            setTimeout(function() {
                $(".alert").alert('close');
            }, 5000);
        });
    </script>
    @stack('js')
</body>

</html>
