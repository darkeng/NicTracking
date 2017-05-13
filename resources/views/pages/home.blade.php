@extends('layouts.main')

@section('title', 'Inicio')

@section('navbar')
    @include('shared.navbar')
    <div class="wrapper wrapper-full-page">
        <div class="full-page home-page" filter-color="black" data-image="{{ asset('img/fondo.jpg') }}">
@endsection

@section('content')
<div class="content">
<div class="container-fluid">
	<div class="jumbotron" style="background-image: url({{ asset('img/banner.jpg') }}); background-size: 100%;">
		<div class="row">
			<div class="col-md-9">
				<div style="background-color: rgba(0,0,0,.2);color: #eee;">
				  <h1>No lo pierdas de vista!</h1>
				  <p>Manten tus vehiculos localizados en todo momento con nuestro servicio de rastreo online en vivo.</p>
				  
				</div>
				<p>
			  <a class="btn btn-primary btn-lg" href="/tracking-panel/general" role="button">
			  @if(Auth::check())
			  		Ir al administrador
              @else
                    Ver la demo
              @endif
			  </a>
			  </p>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-content">
			<div class="row">
				<div class="col-md-8">
					<div class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube.com/embed/UoBUXOOdLXY" allowfullscreen></iframe>
					</div>
				</div>
				<div class="col-md-4">
					<h5 class="card-title">Massimo Banzi - Fundador de Arduino</h4>
					<hr>
					Massimo Banzi ayudó a inventar el Arduino, un minúsculo microcontrolador de código abierto de fácil uso que inspiró a miles de personas en todo el mundo a hacer cosas impresionantes, desde juguetes hasta equipos de satelitales. Porque, como él dice: <h4 class="card-description"> "No necesitas el permiso de nadie para hacer algo grande".</h4>
				</div>
			</div>
		</div>
	</div>
    <div class="card">
	    <div class="row">
			<div class="col-md-12">
	            <div class="card-header">
	                <h4 class="card-title">Conoce la plataforma -
	                    <small>componentes principales</small>
	                </h4>
	            </div>
	            <div class="card-content">
	                <div class="row">
	                    <div class="col-md-2">
	                        <ul class="nav nav-pills nav-pills-icons nav-stacked" role="tablist">
	                            <li class="active">
	                                <a href="#arduino-tab" role="tab" data-toggle="tab">
	                                    <i><img src="{{ asset('img/arduino-icon.png') }}"></i> Arduino
	                                </a>
	                            </li>
	                            <li>
	                                <a href="#laravel-tab" role="tab" data-toggle="tab">
	                                    <i><img src="{{ asset('img/laravel-icon.png') }}"></i> Laravel
	                                </a>
	                            </li>
	                            <li>
	                                <a href="#opl-tab" role="tab" data-toggle="tab">
	                                    <i><img src="{{ asset('img/op-icon.png') }}"></i> OpenLayers
	                                </a>
	                            </li>
	                        </ul>
	                    </div>
	                    <div class="col-md-10">
	                        <div class="tab-content">
	                            <div class="tab-pane active" id="arduino-tab">
	                                <h4>¿Que es?</h4>
	                                <p><a href="http://www.arduino.org">Arduino</a> es una plataforma de prototipos electrónica de código abierto (open-source) basada en hardware y software flexibles y fáciles de usar. Está pensado para artistas, diseñadores, como hobby y para cualquiera interesado en crear objetos o entornos interactivos.</p>
	                                <hr>
	                                <h4>¿Que funcion tiene en el ptoyecto?</h4>
	                                <p>Junto con el modulo de expansion (SIM808) para soporte de redes GPS, GSM y GPRS conforman el dispositivo rastreador o "Tracker", el cual se encarga de recoger y enviar datos de geolocalizacion a los servidores de la plataforma atravez de la api de la misma por medio del protocolo HTTP.</p>
	                            </div>
	                            <div class="tab-pane" id="laravel-tab">
	                                <h4>¿Que es?</h4>
	                                <p><a href="https://laravel.com">Laravel</a> es un framework de código abierto para desarrollar aplicaciones y servicios web con PHP 5 y PHP 7. Su filosofía es desarrollar código PHP de forma elegante y simple, evitando el "código espagueti". Fue creado en 2011 y tiene una gran influencia de frameworks como Ruby on Rails, Sinatra y ASP.NET MVC.</p>
	                                <hr>
	                                <h4>¿Que funcion tiene en el ptoyecto?</h4>
	                                <p>Una de las funciones mas importantes es que es la base para la creacion de la Api Rest que conforma la plataforma, ademas que fue utilizada para la creacion de la web principal la cual presenta una interfaz que permite a los usuarios administrar y monitorear sus vehiculos en tiempo real.</p>
	                            </div>
	                            <div class="tab-pane" id="opl-tab">
	                            	<h4>¿Que es?</h4>
	                            	<p><a href="http://openlayers.org">OpenLayers</a>  es una biblioteca de JavaScript de código abierto bajo una derivación de la licencia BSD para mostrar mapas interactivos en los navegadores web. OpenLayers ofrece un API para acceder a diferentes fuentes de información cartográfica en la red: Web Map Services, Mapas comerciales (tipo Google Maps, Bing, Yahoo), Web Features Services, distintos formatos vectoriales, mapas de OpenStreetMap, etc.</p>
	                            	<hr>
	                            	<h4>¿Que funcion tiene en el ptoyecto?</h4>
	                            	<p>Es la mejor alternativa de codigo abierto (Open-Source) para mostrar los datos recogidos por los rastreadores a traves de cualquier fuente cartografia, en nuestro caso utilizamos <a href="http://www.openstreetmap.org">OpenStreetMap.org</a> por ser la alternativa mas completa y de codigo abierto.</p>
	                            </div>
	                        </div>
	                    </div>
	                </div>
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
