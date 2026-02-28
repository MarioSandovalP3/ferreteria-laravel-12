<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'Super Administrador';
        $user->email = 'super@email.com';
        $user->password = Hash::make('super.123');
        $user->role = 'Super Admin';
        $user->account_state = 'Active';
        $user->save();
    }
}
