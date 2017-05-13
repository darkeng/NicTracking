@extends('layouts.main')

@section('title', 'Graficos y estadisticas')

@section('sidebar')
  	<div class="wrapper">
		@include('shared.sidebar')
@endsection

@section('navbar')
    	<div class="main-panel">
			@include('shared.navbar')
@endsection


@section('content')
			<div class="content">
				<div class="container-fluid">
				    Graficos y estadisticas
				</div>
			</div>
@endsection

@section('footer')
			@include('shared.footer')
		</div>
	</div>
@endsection