<?php

namespace Database\Seeders;

use App\Enums\RoleSlug;
use App\Enums\UserStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SellerSeeder extends Seeder
{
    public function run(): void
    {
        $sellerRole = Role::where('slug', RoleSlug::Seller->value)->first();

        User::updateOrCreate(
            ['email' => 'vendedor@marketplace.com'],
            [
                'role_id' => $sellerRole->id,
                'name' => 'Vendedor Demo',
                'password' => Hash::make('12345'),
                'status' => UserStatus::Approved,
                'must_change_password' => false,
                'email_verified_at' => now(),
                'phone' => '+351 900 000 001',
                'address' => 'Porto, Portugal',
            ]
        );
    }
}
