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
Route::pattern('no_existe', '.*');

Route::group(array('prefix'=>'api'), function()
{
	Route::resource('usuarios', 'Api\UserController',
		['except' => ['edit', 'create']]);

	Route::resource('usuarios.vehiculos', 'Api\UserVehiculoController',
		['except' => ['edit', 'create']]);

	Route::resource('vehiculos', 'Api\VehiculoController',
		['only' => ['index', 'show']]);

	Route::resource('vehiculos.tracker', 'Api\VehiculoTrackerController',
		['except' => ['show', 'edit', 'create']]);

	Route::resource('trackers', 'Api\TrackerController',
		['only' => ['index', 'show']]);

	Route::resource('trackers.posiciones', 'Api\TrackerPosicionController',
		['except' => ['edit', 'create', 'update']]);
});

Route::any('/{no_existe}', function ()
	{
		return response()->json(['mensaje' => 'Ruta y/o metodo no existe.', 'codigo' => 400], 400);
	});

