<?php

use Illuminate\Database\Seeder;
use App\Usuario;
use Faker\Factory;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker=Factory::create('es_ES');
    	for($i=0; $i<3; $i++)
    	{
	        Usuario::create([
	        	'nombre' => $faker->firstNameMale(),
	        	'apellido' => $faker->lastName(),
	        	'correo' => $faker->freeEmail(),
	        	'contra' => $faker->word().$faker->randomNumber(3),
	        	'foto' => $faker->imageUrl(300, 320, 'people'),
	        	'direccion' => $faker->address()
	        	]);
	    }
    }
}
