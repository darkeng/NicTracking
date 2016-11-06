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

        for($i=1; $i<=$nTrackers; $i++)
        {
        	for($o=0; $o<50; $o++)
        	{
        		Posicion::create
        		([
        			'lat' => $faker->latitude(-86, -85),
        			'lan' => $faker->longitude(12, 13),
        			'fecha_registro' => date("Y-m-d H:i:s"),
        			'tracker_id' => $i
        		]);
        	}
        }
    }
}
