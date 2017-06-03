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
            'name' => 'Engell93',
            'email' => 'engell@admin.com',
            'type' => 'admin',
            'password' => Hash::make('123'),
            'avatar' => 'img/avatars/engell.jpg'
        ]);

        User::create([
            'name' => 'MarioBros',
            'email' => 'mario@normal.com',
            'type' => 'normal',
            'password' => Hash::make('321'),
            'avatar' => 'img/avatars/mario.jpg'
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
