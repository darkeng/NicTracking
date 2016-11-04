<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posicion extends Model
{
    protected $table = 'posiciones';
	protected $filleble = array('lat', 'lan', 'fecha_registro', 'tracker_id');
	
	public function tracker()
	{
		$this->belongsTo('Tracker');
	}
}
