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

Route::get('/', function()
{
	return view('pages.home');
});
Route::group(['prefix' => 'tracking-panel'], function()
{
	Route::get('general', function()
	{
		return view('tracking-panel.general');
	});
	Route::get('map', function()
	{
		return view('tracking-panel.map');
	});
	Route::get('charts', function()
	{
		return view('tracking-panel.charts');
	});
	Route::get('vehicles', function()
	{
		return view('tracking-panel.vehicles');
	});
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::group(array('prefix'=>'api'), function()
{
	Route::resource('usuarios', 'Api\UserController',
		['except' => ['edit', 'create']]);

	Route::resource('usuarios.vehiculos', 'Api\UserVehiculoController',
		['except' => ['edit', 'create']]);

	Route::resource('usuarios.vehiculos.tracker', 'Api\UserVehiculoTrackController',
		['only' => ['index', 'store']]);

	Route::match(['put', 'patch'], 'usuarios/{usuarios}/vehiculos/{vehiculos}/tracker', 'Api\UserVehiculoTrackController@update');

	Route::delete('usuarios/{usuarios}/vehiculos/{vehiculos}/tracker', 'Api\UserVehiculoTrackController@destroy');

	Route::get('usuarios/{usuarios}/vehiculos/{vehiculos}/tracker/posiciones', 'Api\UserVehiculoTrackPosController@index');

	Route::post('usuarios/{usuarios}/vehiculos/{vehiculos}/tracker/posiciones', 'Api\UserVehiculoTrackPosController@store');

	Route::delete('usuarios/{usuarios}/vehiculos/{vehiculos}/tracker/posiciones/{posiciones}', 'Api\UserVehiculoTrackPosController@destroy');

	Route::resource('vehiculos', 'Api\VehiculoController', ['only' => ['index', 'show']]);

	Route::resource('trackers', 'Api\TrackerController', ['only' => ['index', 'show']]);

	Route::resource('posiciones', 'Api\PosicionController', ['only' => ['index', 'show']]);

});

Route::any('/{no_existe}', function ()
	{
		return response()->json(['mensaje' => 'Ruta y/o metodo no existe.', 'codigo' => 400], 400);
	});

