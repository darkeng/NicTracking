<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $table = 'trackers';
	protected $fillable = array('imei', 'numSIM', 'descripcion', 'vehiculo_id');
	protected $hidden = ['created_at', 'updated_at'];

	public function posiciones()
	{
		return $this->hasMany('App\Posicion');
	}

	public function vehiculo()
	{
		return $this->belongsTo('App\Vehiculo');
	}
}
