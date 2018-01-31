<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = factory(User::class)->times(50)->make();

        User::insert($users->makeVisible('password')->makeVisible('remember_token')->toArray());

        $user = User::find(1);
        $user->name = 'Harlan';
        $user->email = 'luoxwen@gmail.com';
        $user->save();
    }
}