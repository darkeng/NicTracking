<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table='usuarios';
	protected $fillable = array('nombre', 'apellido', 'correo', 'contra', 'foto', 'direccion');

	protected $hidden = array('contra');

	public function vehiculo()
	{
		$this->hasMany('Vehiculo');
	}
}
