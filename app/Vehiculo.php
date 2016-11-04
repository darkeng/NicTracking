<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculos';
	protected $fillable = array('tipo', 'marca', 'modelo', 'color', 'matricula', 'usuario_id');
	
	public function usuario()
	{
		$this->belongsTo('Usuario');
	}

	public function tracker()
	{
		$this->belongsTo('Tracker');
	}
}
