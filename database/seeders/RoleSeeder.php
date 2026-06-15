<?php

namespace Database\Seeders;

use App\Enums\RoleSlug;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Administrador', 'slug' => RoleSlug::Admin->value, 'description' => 'Gestão total do sistema'],
            ['name' => 'Vendedor', 'slug' => RoleSlug::Seller->value, 'description' => 'Gestão de produtos e vendas'],
            ['name' => 'Cliente', 'slug' => RoleSlug::Customer->value, 'description' => 'Compras e pedidos'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
