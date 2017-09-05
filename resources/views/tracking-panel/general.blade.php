@extends('layouts.main')

@section('title', 'Vista general')

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
				    <div class="row">
				    	<div class="col-md-12">
			    			<div class="card">
			    				<div class="card-header card-header-text" data-background-color="blue">
			    					<h4 class="card-title">Ultima posicion registrada de tus vehiculos</h4>
			    				</div>
			    				<div class="card-content">
			    					<div id="map-cars" class="map map-big">
				    					<div id='carPopup'></div>
				    					<div id='carList' class="dropdown">
						                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
						                        <i class="material-icons">directions_car</i>
						                        Mis vehiculos<b class="caret"></b>
						                    </a>
						                    <ul class="dropdown-menu listVehicles">
						                        @foreach(Auth::user()->vehiculos()->get() as $vehiculo)
						                        <li data-vehicle='{{ $vehiculo }}'>
						                            <a href="#" onclick="vehiclesClick(this)">
						                            {{ $vehiculo->marca.' '.$vehiculo->modelo }}
						                            </a>
						                        </li>
						                        @endforeach
						                    </ul>		    						
				    					</div>			    						
			    					</div>
			    				</div>
			    			</div>
				    	</div>
				    	<div class="col-md-12">
				    		<div id="24hChart">
				    			
				    		</div>
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
	<script src="{{ asset('js/general.js') }}" type="text/javascript"></script>
@endsection