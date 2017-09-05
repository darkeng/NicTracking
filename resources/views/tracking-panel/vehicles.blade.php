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
    		<div class="row">
    		    <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="blue">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">Lista de vehiculos registrados</h4>
                        <div class="card-content">
                            <div class="table-responsive">
                                <form action="#" method="get" class="form-horizontal">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Fabricante</th>
                                            <th>Modelo</th>
                                            <th>Color</th>
                                            <th>Matricula</th>
                                            <th>Estado</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(Auth::user()->vehiculos()->get() as $vehiculo)
    			                        <tr>
                                            <td class="id hidden">{{ $vehiculo->id }}</td>
    			                        	<td class="tipo">{{ $vehiculo->tipo }}</td>
    			                        	<td class="marca">{{ $vehiculo->marca }}</td>
    			                        	<td class="modelo">{{ $vehiculo->modelo }}</td>
    			                        	<td class="color">{{ $vehiculo->color }}</td>
    			                        	<td class="matricula">{{ $vehiculo->matricula }}</td>
    			                        	@if($vehiculo->perdido)
    											<td class="perdido text-danger">Perdido</td>
    			                        	@else
    											<td class="perdido">Normal</td>
    			                        	@endif
    			                        	<td class="td-actions text-center">
                                                <button type="button" rel="tooltip" class="btn btn-success" title="Editar" onclick="showForm(this, 'edit')">
                                                    <i class="material-icons">edit</i>
                                                </button>
                                                <button type="button" rel="tooltip" class="btn btn-danger" title="Eliminar" onclick="vDelete(this)">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                                <button type="button" rel="tooltip" class="btn" title="Editar Tracker" onclick="showTrack(this)">
                                                    <i class="material-icons">my_location</i>
                                                </button>
                                            </td>
    			                        </tr>
    			                    @endforeach
    			                    <tr>
    				                    <td colspan="7" class="text-center">
    						                <button type="button" class="btn btn-info" onclick="showForm(this, 'add')">
                                            	<i class="material-icons">add</i> Registrar nuevo
                                        	</button>
                                        </td>
    			                    </tr>
                                    </tbody>
                                </table>
                                </form>
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
            <table class="hidden" id="trForm">
                <tr>
                    <td class="id hidden">id</td>
                    <td class="tipo"></td>
                    <td class="marca"></td>
                    <td class="modelo"></td>
                    <td class="color"></td>
                    <td class="matricula"></td>
                    <td class="perdido">Normal</td>
                    <td class="td-actions text-center">
                        <button type="button" rel="tooltip" class="btn btn-success" title="Editar" onclick="showForm(this, 'edit')">
                            <i class="material-icons">edit</i>
                        </button>
                        <button type="button" rel="tooltip" class="btn btn-danger" title="Eliminar" onclick="vDelete(this)">
                            <i class="material-icons">delete</i>
                        </button>
                        <button type="button" rel="tooltip" class="btn" title="Editar Tracker" onclick="showTrack(this)">
                            <i class="material-icons">my_location</i>
                        </button>
                    </td>
                </tr>
            </table>
		</div>
	</div>
@endsection

@section('pagescript')
    <script src="{{ asset('js/vehicles.js') }}" type="text/javascript"></script>
@endsection