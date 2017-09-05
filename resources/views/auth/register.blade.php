@extends('layouts.main')

@section('title', 'Registro de usuarios')

@section('navbar')
    @include('shared.navbar')
    <div class="wrapper wrapper-full-page">
        <div class="full-page register-page" filter-color="black" data-image="{{ asset('img/fondo.jpg') }}">
@endsection

@section('content')
<div class="content">
    <div class="container">
		<div class="row">
            <div class="col-md-6 col-sm-8 col-md-offset-3 col-sm-offset-2">
                <form id="formRegister" data-toggle="validator" method="POST" action="/auth/register">
                    <div class="card card-signup card-hidden">
                        <div class="card-header text-center" data-background-color="blue">
                            <h4 class="card-title">Registrate</h4>
                        </div>
                        <div class="card-content">
                        	{!! csrf_field() !!}
                        	<div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">face</i>
                                </span>
                                <div class="form-group label-floating {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label class="control-label">Nombre de usuario</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required minlength="3" autofocus>
                                    <div class="help-block with-errors"></div>
                                    @if ($errors->has('name'))
                                        <div class="help-block with-errors">
                                            {{ $errors->first('name') }}
                                        </div>
                                        <span class="material-icons form-control-feedback">clear</span>
                                    @endif
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="control-label">Correo electronico</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" data-error="Escribe un email valido" required>
                                    <div class="help-block with-errors"></div>
                                    @if ($errors->has('email'))
                                        <div class="help-block with-errors">
                                            {{ $errors->first('email') }}
                                        </div>
                                        <span class="material-icons form-control-feedback">clear</span>
                                    @endif
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock_outline</i>
                                </span>
                                <div class="form-group label-floating {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="control-label">Contraseña</label>
                                    <input type="password" name="password" id="password" class="form-control" data-minlength="8" data-error="8 caracteres como minimo" required>
                                    <div class="help-block with-errors"></div>
                                    @if ($errors->has('password'))
                                        <div class="help-block with-errors">
                                            {{ $errors->first('password') }}
                                        </div>
                                        <span class="material-icons form-control-feedback">clear</span>
                                    @endif
                                </div>
                            </div>
                            <div class="input-group">
                            	<span class="input-group-addon">
                                    <i class="material-icons">lock_outline</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Confirmar contraseña</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required="true" data-match="#password" data-match-error="Las contraseñas no coinciden">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="footer text-center">
                            <button type="submit" class="btn btn-primary btn-simple btn-wd btn-lg">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
	@include('shared.footer')
        </div>
    </div>
@endsection
@section('pagescript')
    <script type="text/javascript">
        $('#formRegister').validator();
        $(document).ready(function() {
            setTimeout(function() {
                $('.card').removeClass('card-hidden');
            }, 700);
        });
    </script>
@endsection
