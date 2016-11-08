<?php

use Illuminate\Database\Seeder;
use App\Vehiculo;
use App\Tracker;
use Faker\Factory;

class TrackerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {    	
        $vehiculosID=Vehiculo::all(['id']);
        $faker=Factory::create('es_ES');
    	for($i=0; $i<Vehiculo::all(['id'])->count(); $i++)
    	{
	        Tracker::create
	        ([
	        	'imei' => $faker->numerify('1#########'),
	        	'numSIM' => $faker->numerify('8#######'),
	        	'descripcion' => $faker->text(250),
	        	'vehiculo_id' =>$vehiculosID[$i]['id']
	        ]);
	    }
    }
}
