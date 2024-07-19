<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::firstOrCreate(
            ['email' => 'user@shopper.com'],
            ['name' => 'Shopper', 'password' => bcrypt('123123')]
        );
        User::factory()->count(10)->create();
        $supplier = User::firstOrCreate(
            ['email' => 'supplier@example.com'],
            [
                'name' => 'Supplier',
                'password' => bcrypt('123123'),
                'type' => UserType::Supplier,
                'store_name' => 'Specific Store',
            ]
        );
    }
}
