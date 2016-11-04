<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $table = 'trackers';
	protected $fillable = array('imei', 'numSIM', 'descripcion', 'vehiculo_id');
	
	public function posiciones()
	{
		$this->hasMany('Posicion');
	}

	public function vehiculo()
	{
		$this->belongsTo('Vehiculo');
	}
}
