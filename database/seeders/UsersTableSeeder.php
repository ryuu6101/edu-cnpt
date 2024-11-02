<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'username' => 'admin',
                'password' => bcrypt('Cnpt@123'),
                'role_id' => 1,
            ],
        ];

        User::truncate();
        User::insert($data);
    }
}
