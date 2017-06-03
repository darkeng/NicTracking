<?php

use Illuminate\Database\Seeder;
use App\Vehiculo;
use App\User;
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
    	$nUsuarios=User::all()->count();
    	$tipo = array('motocicleta','camion pesado','camion','camioneta','bus', 'van', 'auto cerrado');
        $marca= array('Toyota', 'Honda', 'Mazda', 'Chevrolet', 'Volkswagen', 'Hyundai', 'Nissan', 'Ford', 'Suzuki', 'Mercedes Benz');

        $perdido=1;
        $faker=Factory::create('es_ES');
        for($i=0; $i<10; $i++)
        {
            if($perdido==1) {$perdido=0;}
            else {$perdido=1;}

        	Vehiculo::create
        	([
        		'tipo' => $faker->randomElement($tipo),
        		'marca' => $faker->randomElement($marca),
        		'modelo' => $faker->bothify('??-####'),
        		'color' => $faker->colorName(),
                'matricula' => $faker->randomNumber(6),
        		'perdido' => $perdido,
        		'user_id' => $faker->numberBetween(1,$nUsuarios)
        	]);
        }
    }
}
