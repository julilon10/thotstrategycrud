<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'     => "Julian",
            'email'    => "jlondono@gmail.com",
            'password' => '12341234',
        ]);

    }
}
