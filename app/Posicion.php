<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posicion extends Model
{
    protected $table = 'posiciones';
	protected $fillable = array('velocidad', 'precision', 'lat', 'lon', 'altitud', 'precisionAlt', 'direccion', 'fecha_registro', 'tracker_id');
	protected $hidden = ['created_at', 'updated_at'];
	
	public function tracker()
	{
		$this->belongsTo('App\Tracker');
	}
}
