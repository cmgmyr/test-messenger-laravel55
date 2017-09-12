<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::unguard();
        User::truncate();

        $users = collect([
            [
                'name' => 'Chris Gmyr',
                'email' => 'cmgmyr@gmail.com',
                'password' => Hash::make('pass123'),
            ],
            [
                'name' => 'Taylor Otwell',
                'email' => 'taylorotwell@gmail.com',
                'password' => Hash::make('pass123'),
            ],
            [
                'name' => 'Adam Wathan',
                'email' => 'adam.wathan@gmail.com',
                'password' => Hash::make('pass123'),
            ]
        ]);

        $users->each(function($user) {
            User::create($user);
        });
    }
}
