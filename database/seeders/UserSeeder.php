<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);
        $playerRole = Role::create(['name' => 'player']);
        $subscriberRole = Role::create(['name' => 'subscriber']);

        // $permission = Permission::create(['name' => 'edit articles']);

        $admin = User::create([
            'name' => 'admin',
            'phone' => '8801323174104',
            'email' => 'admin@b2m-tech.com',
            'password' => Hash::make('admin@b2m-tech.com'),
        ]);

        $player = User::create([
            'name' => 'User 1',
            'email' => 'user@b2m-tech.com',
            'phone' => '8801323174102',
            'password' => Hash::make('user@b2m-tech.com'),
        ]);

        $admin->assignRole($adminRole); // Assign 'admin' role to the admin user
        $player->assignRole($playerRole);


    }
}
