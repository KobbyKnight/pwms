<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user=\App\User::create([
            'name'=>'Admin',
            'username'=>'admin',
            'gender'=>'Male',
            'dob'=>date(now()),
            'email'=>'melchi.lg@gmail.com',
            'official_phone'=>'0278248834',
            'password'=>bcrypt('admin123456')
        ]);
        $user->attachRole('1');
    }
}
