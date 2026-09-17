<?php

namespace Database\Seeders;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Dedicated Admin Account
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'fullname' => 'System Administrator',
                'email' => 'admin@eventflare.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // 2. Dedicated Buyer (Client) Account
        User::updateOrCreate(
            ['username' => 'buyer'],
            [
                'fullname' => 'Test Client Host',
                'email' => 'buyer@eventflare.com',
                'password' => Hash::make('password123'),
                'role' => 'buyer',
            ]
        );

        // 3. Dedicated Supplier Account
        $supplierUser = User::updateOrCreate(
            ['username' => 'supplier'],
            [
                'fullname' => 'Test Supplier Partner',
                'email' => 'supplier@eventflare.com',
                'password' => Hash::make('password123'),
                'role' => 'supplier',
            ]
        );

        // Ensure Supplier profile exists for the supplier user
        Supplier::updateOrCreate(
            ['user_id' => $supplierUser->id],
            [
                'business_name' => 'Elite Island Events & Catering',
                'category' => 'Catering',
                'description' => 'Accredited test supplier offering bespoke wedding feasts, audio rigs, and complete event coordination.',
                'contact_phone' => '+94 77 123 4567',
                'location' => 'Colombo 07, Sri Lanka',
                'logo_url' => 'https://images.unsplash.com/photo-1555244162-803834f70033?w=300',
            ]
        );
    }
}
