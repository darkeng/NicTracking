<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculos';
	protected $fillable = array('tipo', 'marca', 'modelo', 'color', 'matricula', 'user_id');
	protected $hidden = ['created_at', 'updated_at'];
	
	public function usuario()
	{
		return $this->belongsTo('App\User');
	}

	public function tracker()
	{
		return $this->hasOne('App\Tracker');
	}
}
