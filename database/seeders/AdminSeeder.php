<?php

namespace Database\Seeders;

use App\Enums\RoleSlug;
use App\Enums\UserStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', RoleSlug::Admin->value)->first();

        User::updateOrCreate(
            ['email' => 'admin@marketplace.com'],
            [
                'role_id' => $adminRole->id,
                'name' => 'Administrador',
                'password' => Hash::make('12345'),
                'status' => UserStatus::Approved,
                'must_change_password' => false,
                'email_verified_at' => now(),
                'phone' => '+351 900 000 000',
                'address' => 'Lisboa, Portugal',
            ]
        );
    }
}
