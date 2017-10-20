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
            'name' => 'Luis',
            'email' => 'luis@example.com',
            'password' => bcrypt('secret'),
        ]);

        // Asignación del rol
        $user->assignRole('Administrator');

        User::create([
            'name' => 'gordon',
            'email' => 'gordon@example.com',
            'password' => bcrypt('secret'),
        ]);
    }
}
