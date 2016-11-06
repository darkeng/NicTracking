<?php

use Illuminate\Database\Seeder;
use App\Vehiculo;
use App\Usuario;
use Faker\Factory;

class VehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$nUsuarios=Usuario::all()->count();
    	$tipo = array('motocicleta','camion pesado','camion','camioneta','bus', 'van', 'auto cerrado');

        $faker=Factory::create('es_ES');
        for($i=0; $i<10; $i++)
        {
        	Vehiculo::create
        	([
        		'tipo' => $faker->randomElement($tipo),
        		'marca' => $faker->company(),
        		'modelo' => $faker->bothify('??-####'),
        		'color' => $faker->colorName(),
        		'matricula' => $faker->randomNumber(6),
        		'usuario_id' => $faker->numberBetween(1,$nUsuarios)
        	]);
        }
    }
}
