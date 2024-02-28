<div class="sidebar" data-color="green" data-background-color="white"
    data-image="{{ asset('material') }}/img/sidebar-1.jpg">
    <!-- Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"
         Tip 2: you can also add an image using data-image tag -->
    <div class="logo">
        <i><img style="width:150px" src="{{ asset('material') }}/img/Intimark.png"></i>
    </div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            @if (auth()->check() &&
                    (auth()->user()->hasRole('Administrador') ||
                        auth()->user()->hasRole('Gerente de Calidad')))
                <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="material-icons">dashboard</i>
                        <p>{{ __('Dashboard') }}</p>
                    </a>
                </li>
                <li class="nav-item {{ $activePage == 'profile' || $activePage == 'user-management' ? ' active' : '' }}">
                    <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
                        <i class="material-icons">admin_panel_settings</i>
                        <p>{{ __('Admin cuentas') }}
                            <b class="caret"></b>
                        </p>
                    </a>
                    <div class="collapse" id="laravelExample">
                        <ul class="nav">
                            <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
                                <a class="nav-link" href="{{ route('profile.edit') }}">
                                    <span class="sidebar-mini"> UP </span>
                                    <span class="sidebar-normal">{{ __('User profile') }} </span>
                                </a>
                            </li>
                            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
                                <a class="nav-link" href="{{ route('user.index') }}">
                                    <span class="sidebar-mini"> UM </span>
                                    <span class="sidebar-normal"> {{ __('User Management') }} </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            <li class="nav-item {{ $activePage == 'profile' || $activePage == 'user-management' ? ' active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#laravelExamples" aria-expanded="true">
                    <i class="material-icons">note_alt</i>
                    <p>{{ __('Formularios Calidad') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="laravelExamples">
                    <ul class="nav">
                        @if (auth()->check() && (auth()->user()->hasRole('Auditor') || auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Gerente de Calidad')) && auth()->user()->Planta == 'Planta1')
                        <li class="nav-item{{ $activePage == 'Etiquetas' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('formulariosCalidad.auditoriaEtiquetas') }}">
                                <i class="material-icons">edit_document</i>
                                <p>{{ __('FCC-014') }}</p>
                                <p style="text-align: center;">{{ __('AUDITORIA ETIQUETAS') }}</p>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'Progreso Corte' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('auditoriaCorte.inicioAuditoriaCorte') }}">
                                <i class="material-icons">edit_document</i>
                                <p>{{ __('FCC-010') }}</p>
                                <p style="text-align: center;">{{ __('AUDITORIA CORTE') }}</p>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'Evaluacion Corte' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('evaluacionCorte.evaluaciondeCorte') }}">
                                <i class="material-icons">edit_document</i>
                                <p>{{ __('F-4') }}</p>
                                <p style="text-align: center;">{{ __('EVALUACION DE CORTE') }}</p>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'Auditoria Limpieza' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('formulariosCalidad.auditoriaLimpieza') }}">
                                <i class="material-icons">edit_document</i>
                                <p>{{ __('FAP-003') }}</p>
                                <p style="text-align: center;">{{ __('AUDITORIA DE LIMPIEZA Y PPP') }}</p>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'Auditoria AQL' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('formulariosCalidad.auditoriaFinalAQL') }}">
                                <i class="material-icons">edit_document</i>
                                <p>{{ __('FCC-010') }}</p>
                                <p style="text-align: center;">{{ __('AUDITORIA FINAL A.Q.L') }}</p>
                            </a>
                        </li>
                        <li class="nav-item{{ $activePage == 'Empaque' ? ' active' : '' }}">
                            <a class="nav-link" href="{{ route('formulariosCalidad.controlCalidadEmpaque') }}">
                                <i class="material-icons">edit_document</i>
                                <p>{{ __('FCC-008') }}</p>
                                <p style="text-align: center;">{{ __('CONTROL DE CALIDAD EMPAQUE') }}</p>
                            </a>
                        </li>
                    @endif
                    @if (auth()->check() && (auth()->user()->hasRole('Auditor') || auth()->user()->hasRole('Administrador') || auth()->user()->hasRole('Gerente de Calidad')) && auth()->user()->Planta == 'Planta2')
                    <li class="nav-item{{ $activePage == 'ScreenPrint' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('ScreenPlanta2.ScreenPrint') }}">
                            <i class="material-icons">edit_document</i>
                            <p>{{ __('Screen Print') }}</p>
                        </a>
                    </li>
                    <li class="nav-item{{ $activePage == 'InspeccionEstampado' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('ScreenPlanta2.InsEstamHorno') }}">
                            <i class="material-icons">edit_document</i>
                            <p>{{ __('Inspección Después De Horno') }}</p>
                        </a>
                    </li>
                    <li class="nav-item{{ $activePage == 'CalidadProcesoPlancha' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('ScreenPlanta2.CalidadProcesoPlancha') }}">
                            <i class="material-icons">edit_document</i>
                            <p>{{ __('Proceso Plancha') }}</p>
                        </a>
                    </li>
                    <li class="nav-item{{ $activePage == 'Maquila' ? ' active' : '' }}">
                        <a class="nav-link" href="{{ route('ScreenPlanta2.Maquila') }}">
                            <i class="material-icons">edit_document</i>
                            <p>{{ __('Maquila') }}</p>
                        </a>
                    </li>
                @endif
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
