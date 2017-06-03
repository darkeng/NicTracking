<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Posicion extends Model
{
    protected $table = 'posiciones';
	protected $fillable = array('velocidad', 'precision', 'lat', 'lon', 'altitud', 'precisionAlt', 'direccion', 'fecha_registro', 'tracker_id');
	protected $hidden = ['created_at', 'updated_at'];
	
	public function tracker()
	{
		$this->belongsTo('App\Tracker');
	}

    public static function getOll($idT)
    {
    	$column = 'fecha_registro';
    	$query=DB::table('posiciones')->select()->where('tracker_id', $idT);
        $query->addSelect(DB::raw("concat($column) as $column"));

        return $query->get();
    }
    public static function getUlt($idT, $value)
    {
    	$column = 'fecha_registro';
        $query=DB::table('posiciones')->select()->where('tracker_id', $idT)->orderBy($column, 'desc')->limit($value);
        $query->addSelect(DB::raw("concat($column) as $column"));

        return $query->get();
    }
    public static function getBetw($idT, $date1, $date2)
    {
        $column = 'fecha_registro';
        $query=DB::table('posiciones')->select()->where('tracker_id', $idT)->whereBetween('fecha_registro', [$date1, $date2]);
        $query->addSelect(DB::raw("concat($column) as $column"));

        return $query->get();
    }
}
