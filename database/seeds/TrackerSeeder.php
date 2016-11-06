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
        $nVehiculos=Vehiculo::all()->count();
        $faker=Factory::create('es_ES');
    	for($i=1; $i<=$nVehiculos; $i++)
    	{
	        Tracker::create
	        ([
	        	'imei' => $faker->numerify('############'),
	        	'numSIM' => $faker->numerify('8#######'),
	        	'descripcion' => $faker->text(250),
	        	'vehiculo_id' =>$i
	        ]);
	    }
    }
}
