@extends('layouts.main')

@section('title', 'Adminitrador de vehiculos')

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
				    Adminitrador de vehiculos
				</div>
			</div>
@endsection

@section('footer')
			@include('shared.footer')
		</div>
	</div>
@endsection