<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
	    $faker = Faker\Factory::create();

	    for($i = 0; $i < 1000; $i++) {
	        App\User::create([
	            'fname' => $faker->userName,
	            'lname' => $faker->userName,
	            'full_name' => $faker->name,
	            'email' => $faker->email,
	            'password' => $faker->password,
	            'gender' => 'male',
	            'confirmation_code' => $faker->password,
	            'dof' => '122141241',
	        ]);
	    }
    }
}
