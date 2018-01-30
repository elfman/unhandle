<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = factory(User::class)->times(50)->make()->each(function ($user) {
            if ($user->id === 1) {
                $user->name = 'Harlan';
                $user->email = 'luoxwen@gmail.com';
            }
        });

        User::insert($users->makeVisible('password')->makeVisible('remember_token')->toArray());
    }
}