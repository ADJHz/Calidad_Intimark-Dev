@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'register', 'title' => __('Intimark-Calidad')])

@section('content')
<div class="container" style="height: auto;">
  <div class="row align-items-center">
    <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
      <form class="form" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="card card-login card-hidden mb-3">
          <div class="card-header card-header-primary text-center">
            <h4 class="card-title"><strong>{{ __('Registrar usuario') }}</strong></h4>
          </div>
          <div class="card-body">
            <div class="bmd-form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">face</i>
                  </span>
                </div>
                <input type="text" name="name" class="form-control" placeholder="{{ __('Nombre...') }}" value="{{ old('name') }}" required>
              </div>
              @if ($errors->has('name'))
                <div id="name-error" class="error text-danger pl-3" for="name" style="display: block;">
                  <strong>{{ $errors->first('name') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('no_empleado') ? ' has-danger' : '' }}">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="material-icons">numbers</i>
                        </span>
                    </div>
                    <input type="number" name="no_empleado" class="form-control" placeholder="{{ __('# Empleado...') }}" value="{{ old('no_empleado') }}" required oninput="validateNoEmpleado(this)">
                </div>
                @if ($errors->has('no_empleado'))
                    <div id="no_empleado-error" class="error text-danger pl-3" for="no_empleado" style="display: block;">
                        <strong>{{ $errors->first('no_empleado') }}</strong>
                    </div>
                @endif
              </div>
            <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">email</i>
                  </span>
                </div>
                <input type="email" name="email" class="form-control" placeholder="{{ __('Email...') }}" value="{{ old('email') }}" required>
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
                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password...') }}" required oninput="comparePasswords()">
                <div class="input-group-append">
                  <span class="input-group-text show-password-toggle" style="cursor: pointer;" onclick="togglePasswordVisibility('password')"> <i class="material-icons">visibility</i>{{ __('Ver') }}</span>
                </div>
              </div>
              @if ($errors->has('password'))
                <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                  <strong>{{ $errors->first('password') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">lock_outline</i>
                  </span>
                </div>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Confirm Password...') }}" required oninput="comparePasswords()">
                <div class="input-group-append">
                  <span class="input-group-text show-password-toggle" style="cursor: pointer;" onclick="togglePasswordVisibility('password_confirmation')"> <i class="material-icons">visibility</i>{{ __('Ver') }}</span>
                </div>
              </div>
              @if ($errors->has('password_confirmation'))
                <div id="password_confirmation-error" class="error text-danger pl-3" for="password_confirmation" style="display: block;">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                </div>
              @endif
            </div>

            <!-- Nuevo elemento para mostrar el mensaje de coincidencia/no coincidencia -->
            <div id="password-match-message" class="mt-3"></div>
          </div>
          <div class="card-footer justify-content-center">
            <button type="submit" class="btn btn-primary btn-link btn-lg">{{ __('Crear Cuenta') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
    function togglePasswordVisibility(inputId) {
      var passwordInput = document.getElementById(inputId);
      passwordInput.type = (passwordInput.type === 'password') ? 'text' : 'password';
    }

    function comparePasswords() {
      var password = document.getElementById('password').value;
      var confirmPassword = document.getElementById('password_confirmation').value;
      var messageElement = document.getElementById('password-match-message');

      if (password === confirmPassword) {
        messageElement.innerHTML = '<span style="color: green;">Las contraseñas coinciden.</span>';
      } else {
        messageElement.innerHTML = '<span style="color: red;">Las contraseñas no coinciden.</span>';
      }
    }
</script>
<script>
    function validateNoEmpleado(input) {
        var min = 1000000;
        var max = 9999999999;

        if (input.value < min) {
            input.setCustomValidity("Número de empleado debe ser de al menos 7 dígitos.");
        } else if (input.value > max) {
            input.setCustomValidity("Número de empleado no debe exceder los 10 dígitos.");
        } else {
            input.setCustomValidity("");
        }
    }
</script>
@endsection
