<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name' => 'admin',
        	'type' => 'Admin',
        	'email' => 'admin@fkilibrary.com',
        	'password' => bcrypt('admin123')
        ]);

        User::create([
        	'name' => 'fkico',
        	'type' => 'Coordinator',
        	'email' => 'fkico@fkilibrary.com',
        	'password' => bcrypt('fkico123')
        ]);
    }
}
