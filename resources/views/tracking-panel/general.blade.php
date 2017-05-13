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
				    General
				</div>
			</div>
@endsection

@section('footer')
			@include('shared.footer')
		</div>
	</div>
@endsection