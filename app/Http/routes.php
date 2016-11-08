<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::resource('usuarios', 'UserController',
	['except' => ['edit', 'create']]);

Route::resource('usuarios.vehiculos', 'UserVehiculoController',
	['except' => ['edit', 'create']]);

Route::resource('vehiculos', 'VehiculoController',
	['only' => ['index', 'show']]);

Route::resource('vehiculos.tracker', 'VehiculoTrackerController',
	['except' => ['show', 'edit', 'create']]);

Route::resource('trackers', 'TrackerController',
	['only' => ['index', 'show']]);

Route::resource('trackers.posiciones', 'TrackerPosicionController',
	['except' => ['edit', 'create']]);

