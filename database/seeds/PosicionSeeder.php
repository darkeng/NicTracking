<?php

use Illuminate\Database\Seeder;
use App\Tracker;
use App\Posicion;
use Faker\Factory;

class PosicionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$nTrackers=Tracker::all()->count();
        $faker=Factory::create('es_ES');

        for($i=1; $i<$nTrackers; $i++)
        {
        	for($o=0; $o<50; $o++)
        	{
        		Posicion::create
        		([
                    'velocidad' => $faker->randomFloat(4, 0, 7),
                    'precision' => $faker->randomDigit(),
        			'lat' => $faker->latitude(-87, -83),
                    'lon' => $faker->longitude(11, 14),
                    'altitud' => $faker->randomNumber(3),
                    'precisionAlt' => $faker->randomDigit(),
        			'direccion' => $faker->randomFloat(0, 0, 360),
        			'fecha_registro' => date("Y-m-d H:i:s"),
        			'tracker_id' => $i
        		]);
        	}
        }
    }
}
