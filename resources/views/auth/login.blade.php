@extends('layouts.main')

@section('title', 'Inicio de sesion')

@section('navbar')
    @include('shared.navbar')
    <div class="wrapper wrapper-full-page">
        <div class="full-page login-page" filter-color="black" data-image="{{ asset('img/fondo.jpg') }}">
@endsection

@section('content')
<div class="content">
    <div class="container">
		<div class="row">
            <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                <form method="POST" action="/auth/login">
                    <div class="card card-login card-hidden">
                        <div class="card-header text-center" data-background-color="blue">
                            <h4 class="card-title">Inicia sesion</h4>
                        </div>
                        <div class="card-content">
                        	{!! csrf_field() !!}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Correo electronico</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control">
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock_outline</i>
                                </span>
                                <div class="form-group label-floating">
                                    <label class="control-label">Contraseña</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
	                            <div class="checkbox">
	                            	<label for="remember">
	                            	<input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>Recordarme.
	                            	</label>
	                            </div>
                            </div>
                        </div>
                        <div class="footer text-center">
                            <button type="submit" class="btn btn-rose btn-simple btn-wd btn-lg">Enviar</button>
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
