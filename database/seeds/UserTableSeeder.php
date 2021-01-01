<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Course;

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

        Course::create([
            'course_code' => 'HC12',
            'course_name' => 'Multimedia Technology'
        ]);

        Course::create([
            'course_code' => 'HC13',
            'course_name' => 'Business Computing'
        ]);
    }
}
