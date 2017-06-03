@extends('layouts.main')

@section('title', 'Mapa de seguimiento')

@section('sidebar')
  	<div class="wrapper">
		@include('shared.sidebar')
@endsection

@section('navbar')
    	<div class="main-panel">
			@include('shared.navbar')
@endsection


@section('content')
			
	<div id="map">
    	
    </div>
    
@endsection

@section('footer')
			@include('shared.footer')
		</div>
	</div>
@endsection

@section('pagescript')
	<script src="{{ asset('js/map.js') }}" type="text/javascript"></script>
@endsection