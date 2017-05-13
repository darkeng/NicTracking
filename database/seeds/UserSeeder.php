<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Factory;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=Factory::create('es_ES');
        User::create([
                'name' => 'alexis93',
                'email' => 'fake@fake.com',
                'password' => Hash::make('123'),
                'avatar' => 'img/avatars/engell.jpg'
                ]);
        /*
    	for($i=0; $i<3; $i++)
    	{
            $nombre=$faker->firstNameMale();
            $apellido=$faker->lastName();
	        User::create([
	        	'nombre' => $nombre,
	        	'apellido' => $apellido,
	        	'email' => $nombre.$apellido.'@'.$faker->freeEmailDomain(),
	        	'password' => $faker->word().$faker->randomNumber(3),
	        	'foto' => $faker->imageUrl(300, 320, 'people'),
	        	'direccion' => $faker->address()
	        	]);
	    }*/
    }
}
