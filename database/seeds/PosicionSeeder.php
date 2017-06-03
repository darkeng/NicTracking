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
                $t = microtime(true);
                $micro = sprintf("%03d",($t - floor($t)) * 1000);
                $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );
        		Posicion::create
        		([
                    'velocidad' => $faker->randomFloat(4, 0, 7),
                    'precision' => $faker->randomDigit(),
        			'lat' => $faker->latitude(-86.91, -86.84),
                    'lon' => $faker->longitude(12.41, 12.46),
                    'altitud' => $faker->randomNumber(3),
                    'precisionAlt' => $faker->randomDigit(),
        			'direccion' => $faker->randomFloat(0, 0, 360),
        			'fecha_registro' => $d->format("Y-m-d H:i:s.u"),
        			'tracker_id' => $i
        		]);
        	}
        }
    }
}
