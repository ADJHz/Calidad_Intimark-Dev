@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'login', 'title' => __('Intimark-Calidad')])

@section('content')
<div class="container" style="height: auto;">
  <div class="row align-items-center">
    <div class="col-md-9 ml-auto mr-auto mb-3 text-center">
      <h3>{{ __('Portal calidad.') }} </h3>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
      <form class="form" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="card card-login card-hidden mb-3" id="cardLogin">
          <div class="card-header card-header-primary text-center">
            <h4 class="card-title"><strong>{{ __('Iniciar Sesion') }}</strong></h4>
          </div>
          <div class="card-body bg-white" id="emailLoginForm">
            <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">person</i>
                  </span>
                </div>
                <input type="text" name="email" class="form-control" placeholder="{{ __('Email Ó # Empleado') }}" value="{{ old('email') }}" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}">
              </div>
              @if ($errors->has('email'))
                <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                  <strong>{{ $errors->first('email') }}</strong>
                </div>
              @endif
            </div>

            <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">lock_outline</i>
                  </span>
                </div>
                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password...') }}" required>
                <div class="input-group-append">
                  <span class="input-group-text show-password-toggle" style="cursor: pointer;" onclick="togglePasswordVisibility('password')"><i class="material-icons">visibility</i>{{ __('Ver') }}</span>
                </div>
              </div>
              @if ($errors->has('password'))
                <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                  <strong>{{ $errors->first('password') }}</strong>
                </div>
              @endif
            </div>

            <div class="form-check mr-auto ml-3 mt-3">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Recordar Cuenta') }}
                <span class="form-check-sign">
                  <span class="check"></span>
                </span>
              </label>
            </div>
          </div>
          <div class="card-footer justify-content-center">
            <button type="submit" class="btn btn-primary btn-link btn-lg">{{ __('Iniciar Sesion') }}</button>
          </div>
        </div>
      </form>
      <div class="row">
        <div class="col-6">
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-light">
              <small>{{ __('Contraseña olvidada?') }}</small>
            </a>
          @endif
        </div>
        <div class="col-6 text-right">
          <a href="{{ route('register') }}" class="text-light">
            <small>{{ __('Crear nueva cuenta') }}</small>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function togglePasswordVisibility(inputId) {
    var passwordInput = document.getElementById(inputId);
    passwordInput.type = (passwordInput.type === 'password') ? 'text' : 'password';
  }
</script>

@endsection
